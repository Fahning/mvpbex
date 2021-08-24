<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeTransferencia;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoTransferenciaRota extends Component
{
    public $dataGraf;

    protected $listeners = ['filtros'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataTransfRota',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function formatData($data)
    {
        $dataGraf = [
            'rota' => [],
            'custo_cubagem' => [],
            'custo_peso' => []
        ];
        foreach ($data as $value){
            $value = (array)$value;
            array_push($dataGraf['rota'], $value['rota']);
            array_push($dataGraf['custo_cubagem'], $value['custo_cubagem']);
            array_push($dataGraf['custo_peso'], $value['custo_peso']);
        }
        return $dataGraf;
    }


    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'mf')
            ->select(
                DB::raw("CONCAT(mf.und_origem,' ➔ ' ,mf.und_destino) AS rota"),
                DB::raw('SUM(mf.custo_peso) AS custo_peso'),
                DB::raw('SUM(mf.custo_cubagem) AS custo_cubagem'),
            )
            ->whereNotNull('mf.custo_peso')
            ->whereYear('mf.emissao_manif', Carbon::today()->year)
            ->whereMonth('mf.emissao_manif', Carbon::today()->month)
            ->groupBy('rota')
            ->orderBy('custo_peso', 'desc')
            ->get();
    }

    public function filtros($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'mf')
            ->select(
                DB::raw("CONCAT(mf.und_origem,' ➔ ' ,mf.und_destino) AS rota"),
                DB::raw('SUM(mf.custo_peso) AS custo_peso'),
                DB::raw('SUM(mf.custo_cubagem) AS custo_cubagem'),
            )
            ->whereNotNull('mf.custo_peso')
            ->whereYear('mf.emissao_manif', $filtros['ano'])
            ->whereMonth('mf.emissao_manif', $filtros['mes'])
            ->when($filtros['searchCliente'], function ($query) use($filtros){
                $query->where('nome_pagador', $filtros['searchCliente']);
            })
            ->when($filtros['searchBase'], function ($query) use($filtros){
                $query->whereIn('und_origem', $filtros['searchBase']);
            })
            ->when($filtros['searchSegmentos'], function ($query) use($filtros){
                $query->whereIn('segmento', $filtros['searchSegmentos']);
            })
            ->groupBy('rota')
            ->orderBy('custo_peso', 'desc')
            ->get();

        $this->dispatchBrowserEvent(
            'renderDataTransfRota',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-transferencia.grafico-transferencia-rota');
    }
}
