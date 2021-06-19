<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartSegmento extends Component
{
    public $cSegmento;
    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function hydrate($property)
    {
        dd($property);
    }

    public function mount()
    {
        $dataSegmento = DB::select("CALL dw_atual.fat_persp(".Carbon::today()->year.",".Carbon::today()->subMonth()->month.", 'Segmento')");
        $this->fatoraSegmento($dataSegmento);
    }

    public function fatoraSegmento($dataSegmento)
    {
        $this->cSegmento = [
            'categories' => [],
            'series' => []
        ];
        foreach ($dataSegmento as $d){
            array_push($this->cSegmento['categories'], $d->Segmento);
            array_push($this->cSegmento['series'], intval($d->Receita));
        }
    }

    public function reader()
    {
        return view('livewire.components.analise-segmento.chart-segmento');
    }
}
