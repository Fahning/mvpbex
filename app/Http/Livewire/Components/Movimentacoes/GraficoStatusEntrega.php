<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoStatusEntrega extends Component
{
    public $dataGraf;

    protected $listeners = ['filtroMovimentacoes' => 'filtrar'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataStatusEntrega',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.tabela_saida_entrega', 'tb')
            ->selectRaw(
            "IF(cod.tipo IS NULL, 'OUTROS', cod.tipo) as tipo, COUNT(0) as quantidade"
            )
            ->leftJoin('bexsal_bdsal.classificacao_ocorrencias as cod', 'tb.codigo_ultima_ocorrencia', '=', 'cod.codigo')
            ->whereNotIn('cod.tipo',['DESCONSIDERAR', 'ENTREGA FINALIZADA'])
            ->groupBy('cod.tipo')
            ->orderBy('quantidade', 'desc')
            ->take(30)
            ->get();

    }

    public function formatData($data)
    {
        $dataGraf = [
            'tipo' => [],
            'quantidade' => []
        ];
        foreach ($data as $value){
            $value = (array)$value;
            array_push($dataGraf['tipo'], $value['tipo']);
            array_push($dataGraf['quantidade'], $value['quantidade']);
        }
        return $dataGraf;
    }



    public function filtrar($filtros)
    {

        $this->dataGraf = DB::table('bexsal_reports.tabela_saida_entrega', 'tb')
            ->selectRaw(
                "IF(cod.tipo IS NULL, 'OUTROS', cod.tipo) as tipo, COUNT(0) as quantidade"
            )
            ->leftJoin('bexsal_bdsal.classificacao_ocorrencias as cod', 'tb.codigo_ultima_ocorrencia', '=', 'cod.codigo')
            ->whereNotIn('cod.tipo',['DESCONSIDERAR', 'ENTREGA FINALIZADA'])
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
            ->groupBy('cod.tipo')
            ->orderBy('quantidade', 'desc')
            ->take(30)
            ->get();

        $this->dispatchBrowserEvent(
            'renderDataStatusEntrega',
            [
                'newData' =>$this->formatData($this->dataGraf)
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.movimentacoes.grafico-status-entrega');
    }
}
