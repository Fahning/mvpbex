<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartBases extends Component
{
    public $chartBases;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount() {
        $chartBases = DB::select("call dw_atual.fat_persp(".Carbon::today()->year.",".Carbon::today()->subMonth()->month.", 'Base')");
        $this->fatoraBases($chartBases);
    }

    public function filtrar($filtros)
    {
        dd($filtros);
//        $chartBases = DB::select("call dw_atual.fat_persp(".$filtros['year'].",".$filtros['month'].", 'Base')");
//        $this->fatoraBases($data);
    }

    public function fatoraBases($chartBases){
        $this->chartBases = [
            'categories' => [],
            'series' => []
        ];
        foreach ($chartBases as $d){
            array_push($this->chartBases['categories'], $d->Base);
            array_push($this->chartBases['series'], intval($d->Receita));
        }
    }
    public function render()
    {
        return view('livewire.components.chart-bases');
    }
}
