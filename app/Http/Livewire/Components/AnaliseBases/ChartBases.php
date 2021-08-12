<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartBases extends Component
{
    public $series = [];
    public $categories = [];
    public $year;
    public $month;

    protected $sql = "(SELECT nf.ano AS Ano, nf.mes AS M, nf.trimestre, nf.segmento AS Segmento,nf.nome_pagador AS Cliente,nf.und_receptora AS Base,SUM(nf.val_frete) AS Receita FROM tabela_ctes nf GROUP BY nf.segmento, nf.nome_pagador, nf.und_receptora, nf.ano , nf.mes) as cc";

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
        $chartBase = TabelaCtes::select('und_receptora as base', DB::raw('sum(val_frete) as receita'))
            ->where('ano', Carbon::today()->year)
            ->where('mes', Carbon::today()->month)
            ->orderBy('receita', 'desc')
            ->groupBy('und_receptora')
            ->get();

        foreach ($chartBase as $t)
        {
            array_push($this->categories, $t->base);
            array_push($this->series, floatval($t->receita));
        }

    }

    public function searchBases($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;
        $chartBase = TabelaCtes::select('und_receptora as base', DB::raw('sum(val_frete) as receita'))
            ->Search($filtros)
            ->orderBy('receita', 'desc')
            ->groupBy('und_receptora')
            ->get();

        $this->categories = [];
        $this->series = [];
        foreach ($chartBase as $t)
        {
            array_push($this->categories, $t->base);
            array_push($this->series, floatval($t->receita));
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
