<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeTransferencia;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoEvolucaoCustos extends Component
{
    public $dataGraf;

    protected $listeners = ['filtros' => 'filtrar'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataCustTransf',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'cc')
            ->select(
                DB::raw('DATE_FORMAT(cc.emissao_manif, "%Y-%m") AS data_emis'),
                DB::raw('SUM(cc.custo_peso) AS custo_peso'),
                DB::raw('SUM(cc.custo_cubagem) AS custo_cubagem'),
            )
            ->orderBy('cc.emissao_manif', 'asc')
            ->groupBy('data_emis')
            ->get();

    }

    public function filtrar($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;

        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'cc')
            ->select(
                DB::raw('DATE_FORMAT(cc.emissao_manif, "%Y-%m") AS data_emis'),
                DB::raw('SUM(cc.custo_peso) AS custo_peso'),
                DB::raw('SUM(cc.custo_cubagem) AS custo_cubagem'),
            )
            ->when($filtros['ano'], function ($query) use($filtros){
                $query->whereYear('cc.emissao_manif', $filtros['ano']);
            })
            ->when($filtros['mes'], function ($query) use($filtros){
                $query->whereMonth('cc.emissao_manif', $filtros['mes']);
            })
            ->when($filtros['searchCliente'], function ($query) use($filtros){
                $query->where('cc.nome_pagador', $filtros['searchCliente']);
            })
            ->when($filtros['searchBase'], function ($query) use($filtros){
                $query->whereIn('cc.und_origem', $filtros['searchBase']);
            })
            ->when($filtros['searchSegmentos'], function ($query) use($filtros){
                $query->whereIn("segmento", $filtros['searchSegmentos']);
            })
            ->orderBy('cc.emissao_manif', 'asc')
            ->groupBy('data_emis')
            ->get();

        $this->dispatchBrowserEvent(
            'renderDataCustTransf',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function formatData($data)
    {
        $dataGraf = [
            'data_emis' => [],
            'custo_cubagem' => [],
            'custo_peso' => []
        ];
        foreach ($data as $value){
            $value = collect($value);
            array_push($dataGraf['data_emis'], Carbon::create($value['data_emis'] )->format('F Y'));
            array_push($dataGraf['custo_cubagem'], $value['custo_cubagem']);
            array_push($dataGraf['custo_peso'], $value['custo_peso']);
        }
        return $dataGraf;
    }


    public function render()
    {
        return view('livewire.components.operacional.analise-de-transferencia.grafico-evolucao-custos');
    }
}
