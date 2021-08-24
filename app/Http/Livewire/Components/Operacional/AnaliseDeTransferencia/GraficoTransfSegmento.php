<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeTransferencia;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoTransfSegmento extends Component
{
    public $dataGraf;

    protected $listeners = ['filtros'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataTransfSegmento',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function formatData($data)
    {
        $dataGraf = [
            'segmento' => [],
            'custo_cubagem' => [],
            'custo_peso' => []
        ];
        foreach ($data as $value){
            $value = (array)$value;
            array_push($dataGraf['segmento'], $value['segmento']);
            array_push($dataGraf['custo_cubagem'], $value['custo_cubagem']);
            array_push($dataGraf['custo_peso'], $value['custo_peso']);
        }
        return $dataGraf;
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'mf')
            ->select(
                'mf.segmento',
                DB::raw('SUM(mf.custo_peso) AS custo_peso'),
                DB::raw('SUM(mf.custo_cubagem) AS custo_cubagem'),
            )
            ->whereNotNull('mf.custo_peso')
            ->whereYear('mf.emissao_manif', Carbon::today()->year)
            ->whereMonth('mf.emissao_manif', Carbon::today()->month)
            ->groupBy('mf.segmento')
            ->orderBy('custo_peso', 'desc')
            ->take(40)
            ->get();
    }

    public function filtros($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'mf')
            ->select(
                'mf.segmento',
                DB::raw('SUM(mf.custo_peso) AS custo_peso'),
                DB::raw('SUM(mf.custo_cubagem) AS custo_cubagem'),
            )
            ->whereNotNull('mf.custo_peso')
            ->whereYear('mf.emissao_manif', Carbon::today()->year)
            ->whereMonth('mf.emissao_manif', Carbon::today()->month)
            ->when($filtros['searchCliente'], function ($query) use($filtros){
                $query->where('mf.nome_pagador', $filtros['searchCliente']);
            })
            ->when($filtros['searchBase'], function ($query) use($filtros){
                $query->whereIn('mf.und_origem', $filtros['searchBase']);
            })
            ->when($filtros['searchSegmentos'], function ($query) use($filtros){
                $query->whereIn("mf.segmento", $filtros['searchSegmentos']);
            })
            ->groupBy('mf.segmento')
            ->orderBy('custo_peso', 'desc')
            ->take(40)
            ->get();


        $this->dispatchBrowserEvent(
            'renderDataTransfSegmento',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-transferencia.grafico-transf-segmento');
    }
}
