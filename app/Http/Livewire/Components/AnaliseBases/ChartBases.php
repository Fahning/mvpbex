<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartBases extends Component
{
    public $series = [];
    public $categories = [];
    public $year;
    public $month;

    protected $sql = "(SELECT nf.ano AS Ano, nf.mes AS M, nf.trimestre, nf.segmento AS Segmento,nf.nome_pagador AS Cliente,nf.und_emissora AS Base,SUM(nf.val_frete) AS Receita FROM tabela_ctes nf GROUP BY nf.segmento, nf.nome_pagador, nf.und_emissora, nf.ano , nf.mes) as cc";

    protected $listeners = [
        'filtros' => 'searchBases'
    ];

    public function montaChartBase()
    {
        $this->dispatchBrowserEvent(
            'renderDataBase',
            [
                'categories' => $this->categories,
                'series' => $this->series
            ]
        );
    }

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $chartBase = DB::table(DB::raw($this->sql))
            ->select("cc.Ano", "cc.M AS Mes", "cc.Base", DB::raw('SUM(cc.Receita) as Receita'))
            ->where('cc.Ano', $this->year)
            ->where('cc.M', $this->month)
            ->orderBy('Receita', 'desc')
            ->groupBy('Ano' , 'Mes' , 'Base')
            ->get();

        foreach ($chartBase as $t)
        {
            array_push($this->categories, $t->Base);
            array_push($this->series, floatval($t->Receita));
        }

    }

    public function searchBases($filtros)
    {

        $this->year = $filtros['ano'];
        $this->month = $filtros['mes'];
        $chartBase = DB::table(DB::raw($this->sql))
            ->select("cc.Ano", "cc.M AS Mes", "cc.Base", DB::raw('SUM(cc.Receita) as Receita'))
            ->when($filtros['searchBase'], function($query) use($filtros) {
                $query->whereIn('cc.Base',$filtros['searchBase']);
            })
            ->when(!$filtros['searchBase'], function($query) use($filtros) {
                $query->where('cc.Ano', $this->year);
                $query->where('cc.M', $this->month);
            })
            ->when($filtros['ano'], function($query) use($filtros) {
                $query->where('cc.Ano', $this->year);
            })
            ->when($filtros['mes'], function($query) use($filtros) {
                $query->where('cc.M', $this->month);
            })
            ->when($filtros['trimestre'], function($query) use($filtros) {
                $query->where('cc.trimestre', $filtros['trimestre']);
            })
            ->orderBy('Receita', 'desc')
            ->groupBy('Ano' , 'Mes' , 'Base')
            ->get();

        $this->categories = [];
        $this->series = [];
        foreach ($chartBase as $t)
        {
            array_push($this->categories, $t->Base);
            array_push($this->series, floatval($t->Receita));
        }

        $this->dispatchBrowserEvent(
            'renderDataBase',
            [
                'categories' => $this->categories,
                'series' => $this->series
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.analise-bases.chart-bases');
    }
}
