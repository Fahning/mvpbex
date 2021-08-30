<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoRotaEntrega extends Component
{
    public $dataGraf;

    protected $listeners = ['filtroMovimentacoes' => 'filtrar'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataRotaEntrega',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.tabela_saida_entrega')->selectRaw(
            " `setor destino` as setor,
            COUNT(0) as quantidade"
        )
            ->groupBy('setor')
            ->orderBy('quantidade', 'desc')
            ->take(30)
            ->get();

    }

    public function formatData($data)
    {
        $dataGraf = [
            'rota' => [],
            'quantidade' => []
        ];
        foreach ($data as $value){
            $value = (array)$value;
            array_push($dataGraf['rota'], $value['setor']);
            array_push($dataGraf['quantidade'], $value['quantidade']);
        }
        return $dataGraf;
    }



    public function filtrar($filtros)
    {
        $this->dataGraf = DB::table('bexsal_reports.tabela_saida_entrega')->selectRaw(
            " `setor destino` as setor,
            COUNT(0) as quantidade"
        )
            ->when($filtros, function ($query) use($filtros){
                if($filtros[0]){
                    $query->where('cidade_base', $filtros[0]);
                }
            })
            ->when($filtros, function ($query) use($filtros) {
                if($filtros[1]){
                    $query->whereIn('unidade_receptora', $filtros[1]);
                }
            })
            ->when($filtros, function ($query) use($filtros) {
                if($filtros[2]){
                    $query->where('Cliente', $filtros[2]);
                }
            })
            ->groupBy('setor')
            ->orderBy('quantidade', 'desc')
            ->take(30)
            ->get();

        $this->dispatchBrowserEvent(
            'renderDataRotaEntrega',
            [
                'newData' =>$this->formatData($this->dataGraf)
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.movimentacoes.grafico-rota-entrega');
    }
}
