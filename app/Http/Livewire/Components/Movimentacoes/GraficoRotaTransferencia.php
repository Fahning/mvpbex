<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoRotaTransferencia extends Component
{
    public $dataGraf;

    protected $listeners = ['filtroMovimentacoes' => 'filtrar'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataRotaTansferencia',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.tabela_saida_transferencias')->selectRaw(
            "CONCAT(`Sigla Origem`, ' ➔ ', `Sigla Destino`) as rota,
            COUNT(0) as quantidade"
        )
            ->groupBy('rota')
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
            array_push($dataGraf['rota'], $value['rota']);
            array_push($dataGraf['quantidade'], $value['quantidade']);
        }
        return $dataGraf;
    }



    public function filtrar($filtros)
    {
        $this->dataGraf = DB::table('bexsal_reports.tabela_saida_transferencias')->selectRaw(
            "CONCAT(`Sigla Origem`, ' ➔ ', `Sigla Destino`) as rota,
            COUNT(0) as quantidade"
        )

        ->when($filtros, function ($query) use($filtros){
            if($filtros[0]){
                $query->where('origem', $filtros[0]);
            }
        })
        ->when($filtros, function ($query) use($filtros) {
            if($filtros[1]){
                $query->whereIn('sigla origem', $filtros[1]);
            }
        })
        ->when($filtros, function ($query) use($filtros) {
            if($filtros[2]){
                $query->where('Cliente', $filtros[2]);
            }
        })
        ->groupBy('rota')
        ->get();

        $this->dispatchBrowserEvent(
            'renderDataRotaTansferencia',
            [
                'newData' =>$this->formatData($this->dataGraf)
            ]
        );
    }
    public function render()
    {
        return view('livewire.components.movimentacoes.grafico-rota-transferencia');
    }
}
