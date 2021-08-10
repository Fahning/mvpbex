<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartClientes extends Component
{
    public $series = [];
    public $categories = [];
    public $year;
    public $month;

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
        $chartClient = TabelaCtes::select('nome_pagador', DB::raw('sum(val_frete) as receita'))
            ->where('mes', $this->month)
            ->where('ano', $this->year)
            ->orderBy('receita', 'desc')
            ->groupBy('nome_pagador')
            ->take(50)
            ->get();

        foreach ($chartClient as $t)
        {
            array_push($this->categories, $t->nome_pagador);
            array_push($this->series, floatval($t->receita));
        }

    }

    public function searchClientes($filtros)
    {

        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $chartClient = TabelaCtes::select('nome_pagador', DB::raw('sum(val_frete) as receita'))
            ->Search($filtros)
            ->orderBy('receita', 'desc')
            ->groupBy('nome_pagador')
            ->get();

        $this->categories = [];
        $this->series = [];
        foreach ($chartClient as $t)
        {
            array_push($this->categories, $t->nome_pagador);
            array_push($this->series, floatval($t->receita));
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
