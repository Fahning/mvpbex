<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartSegmento extends Component
{
    public $series = [];
    public $categories = [];
    public $year;
    public $month;


    protected $sql = "(SELECT nf.ano AS Ano, nf.mes AS M, nf.trimestre, nf.segmento AS Segmento,nf.nome_pagador AS Cliente,nf.und_emissora AS Base,SUM(nf.val_frete) AS Receita FROM tabela_ctes nf GROUP BY nf.segmento, nf.nome_pagador, nf.und_emissora, nf.ano , nf.mes) as cc";

    protected $listeners = [
        'filtros' => 'searchSegmentos'
    ];

    public function montaChartSegmento()
    {
        $this->dispatchBrowserEvent(
            'renderDataSegmento',
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
        $chartSegmento = DB::table(DB::raw($this->sql))
            ->select("cc.Ano", "cc.M AS Mes", "cc.Segmento", DB::raw('SUM(cc.Receita) as Receita'))
            ->where('cc.Ano', $this->year)
            ->where('cc.M', $this->month)
            ->orderBy('Receita', 'desc')
            ->groupBy('Ano' , 'Mes' , 'Segmento')
            ->get();


        foreach ($chartSegmento as $t)
        {
            array_push($this->categories, $t->Segmento);
            array_push($this->series, intval($t->Receita));
        }

    }

    public function searchSegmentos($filtros)
    {
        $this->year = $filtros['ano'];
        $this->month = $filtros['mes'];

        $chartSegmento = DB::table(DB::raw($this->sql))
            ->select("cc.Ano", "cc.M AS Mes", "cc.Segmento", DB::raw('SUM(cc.Receita) as Receita'))
            ->where('cc.Ano', $this->year)
            ->where('cc.M', $this->month)
            ->when($filtros['searchSegmentos'], function($query) use($filtros) {
                $query->whereIn('cc.Segmento',$filtros['searchSegmentos']);
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
            ->orderBy('cc.Receita', 'desc')
            ->groupBy('Ano' , 'Mes' , 'Segmento')
            ->get();

        $this->categories = [];
        $this->series = [];
        foreach ($chartSegmento as $t)
        {
            array_push($this->categories, $t->Segmento);
            array_push($this->series, intval($t->Receita));
        }

        $this->dispatchBrowserEvent(
            'renderDataSegmento',
            [
                'categories' => $this->categories,
                'series' => $this->series
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.analise-segmento.chart-segmento');
    }
}
