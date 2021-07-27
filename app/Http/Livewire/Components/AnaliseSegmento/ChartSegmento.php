<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartSegmento extends Component
{
    public $series = [];
    public $categories = [];

    protected $listeners = ['filtros' => 'update'];

    public function mount()
    {
        $teste = DB::select("CALL fat_persp(".Carbon::today()->year.",".Carbon::today()->month.", 'Segmento')");
        foreach ($teste as $t)
        {
            array_push($this->categories, $t->Segmento);
            array_push($this->series, intval($t->Receita));
        }
    }

    public function update($filtro)
    {
        $this->categories = [];
        $this->series = [];
        $teste = DB::select("CALL fat_persp(".$filtro['ano'].",".$filtro['mes'].", 'Segmento')");
        foreach ($teste as $t)
        {
            array_push($this->categories, $t->Segmento);
            array_push($this->series, intval($t->Receita));
        }
        $this->dispatchBrowserEvent('updateChart');
    }

    public function render()
    {
        return view('livewire.components.analise-segmento.chart-segmento');
    }
}
