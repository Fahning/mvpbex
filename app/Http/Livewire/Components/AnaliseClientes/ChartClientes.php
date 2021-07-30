<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartClientes extends Component
{
    public $series = [];
    public $categories = [];
    public $year;
    public $month;

    protected $sql = "(SELECT nf.ano AS Ano, nf.mes AS M, nf.trimestre, nf.segmento AS Segmento,nf.nome_pagador AS Cliente,nf.und_emissora AS Base,SUM(nf.val_frete) AS Receita FROM tabela_ctes nf GROUP BY nf.segmento, nf.nome_pagador, nf.und_emissora, nf.ano , nf.mes) as cc";

    protected $listeners = [
        'filtros' => 'searchClientes'
    ];

    public function montaChartCliente()
    {
        $this->dispatchBrowserEvent(
            'renderDataCliente',
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
        $chartClient = DB::table(DB::raw($this->sql))
            ->select("cc.Ano", "cc.M AS Mes", "cc.Cliente", "cc.Receita")
            ->where('cc.Ano', $this->year)
            ->where('cc.M', $this->month)
            ->orderBy('cc.Receita', 'desc')
            ->groupBy('Ano' , 'Mes' , 'Cliente')
            ->get();

        foreach ($chartClient as $t)
        {
            array_push($this->categories, $t->Cliente);
            array_push($this->series, intval($t->Receita));
        }

    }

    public function searchClientes($filtros)
    {

        $this->year = $filtros['ano'];
        $this->month = $filtros['mes'];

        $chartClient = DB::table(DB::raw($this->sql))
            ->select("cc.Ano", "cc.M AS Mes", "cc.Cliente", "cc.Receita")
            ->when($filtros['searchCliente'], function($query) use($filtros) {
                $query->where('cc.Cliente','LIKE', "%{$filtros['searchCliente']}%");
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
            ->groupBy('Ano' , 'Mes' , 'Cliente')
            ->get();

        $this->categories = [];
        $this->series = [];
        foreach ($chartClient as $t)
        {
            array_push($this->categories, $t->Cliente);
            array_push($this->series, intval($t->Receita));
        }

        $this->dispatchBrowserEvent(
            'renderDataCliente',
            [
                'categories' => $this->categories,
                'series' => $this->series
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.analise-clientes.chart-clientes');
    }
}
