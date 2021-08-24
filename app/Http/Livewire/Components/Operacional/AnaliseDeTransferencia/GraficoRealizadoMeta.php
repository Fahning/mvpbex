<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeTransferencia;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoRealizadoMeta extends Component
{
    public $dataGraf;

    protected $listeners = ['filtros'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataTransfMeta',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'mf')
            ->select(
                DB::raw('DATE_FORMAT(mf.emissao_manif, "%Y-%m") AS data_emis'),
                DB::raw('SUM(mf.val_frete) as Faturamento'),
                DB::raw('SUM(mf.custo_peso) AS custo_peso'),
                DB::raw('SUM(mf.custo_cubagem) AS custo_cubagem'),
                'mt.META_TRANSFERENCIA'
            )
            ->leftJoin('dim_meta as mt', function ($join) {
                $join->on(DB::raw('YEAR(mf.emissao_manif)'), '=',  'mt.ANO');
                $join->on(DB::raw('MONTH(mf.emissao_manif)'), '=',  'mt.MES');
            })
            ->whereYear('mf.emissao_manif', Carbon::today()->year)
            ->orderBy('data_emis')
            ->groupBy('data_emis')
            ->get();
    }

    public function formatData($data)
    {
        $dataGraf = [
            'data_emis' => [],
            'custo_cubagem' => [],
            'custo_peso' => [],
            'meta' => []
        ];
        foreach ($data as $value){
            $value = collect($value);
            array_push($dataGraf['data_emis'], Carbon::create($value['data_emis'] )->format('F Y'));
            array_push($dataGraf['custo_cubagem'], $value['custo_cubagem'] / $value['Faturamento'] * 100 );
            array_push($dataGraf['custo_peso'], $value['custo_peso'] / $value['Faturamento'] * 100);
            array_push($dataGraf['meta'], $value['META_TRANSFERENCIA']);
        }
        return $dataGraf;
    }


    public function filtros($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;

        $this->dataGraf = DB::table('bexsal_reports.base_custos_transf', 'mf')
            ->select(
                DB::raw('DATE_FORMAT(mf.emissao_manif, "%Y-%m") AS data_emis'),
                DB::raw('SUM(mf.val_frete) as Faturamento'),
                DB::raw('SUM(mf.custo_peso) AS custo_peso'),
                DB::raw('SUM(mf.custo_cubagem) AS custo_cubagem'),
                'mt.META_TRANSFERENCIA'
            )
            ->leftJoin('dim_meta as mt', function ($join) {
                $join->on(DB::raw('YEAR(mf.emissao_manif)'), '=',  'mt.ANO');
                $join->on(DB::raw('MONTH(mf.emissao_manif)'), '=',  'mt.MES');
            })
            ->whereYear('mf.emissao_manif', $filtros['ano'])
//            ->when($filtros['searchCliente'], function ($query) use($filtros){
//                $query->where('mf.nome_pagador', $filtros['searchCliente']);
//            })
//            ->when($filtros['searchBase'], function ($query) use($filtros){
//                $query->where('mf.und_origem', $filtros['searchBase']);
//            })
//            ->when($filtros['searchSegmentos'], function ($query) use($filtros){
//                $query->where('mf.segmento', $filtros['searchSegmentos']);
//            })
            ->orderBy('data_emis')
            ->groupBy('data_emis')
            ->get();

        $this->dispatchBrowserEvent(
            'renderDataTransfMeta',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-transferencia.grafico-realizado-meta');
    }
}
