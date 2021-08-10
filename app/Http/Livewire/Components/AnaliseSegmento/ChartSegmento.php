<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartSegmento extends Component
{
    public $series = [];
    public $categories = [];
    public $year;
    public $month;




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
        $chartSegmento = TabelaCtes::select('segmento', DB::raw('sum(val_frete) as receita'))
            ->where('mes', $this->month)
            ->where('ano', $this->year)
            ->orderBy('receita', 'desc')
            ->groupBy('segmento')
            ->get();

        foreach ($chartSegmento as $t)
        {
            array_push($this->categories, $t->segmento);
            array_push($this->series, floatval($t->receita));
        }

    }

    public function searchSegmentos($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;
        $chartSegmento = TabelaCtes::select('segmento', DB::raw('sum(val_frete) as receita'))
        ->Search($filtros)
        ->orderBy('receita', 'desc')
        ->groupBy('segmento')
        ->get();

        $this->categories = [];
        $this->series = [];
        foreach ($chartSegmento as $t)
        {
            array_push($this->categories, $t->segmento);
            array_push($this->series, floatval($t->receita));
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
