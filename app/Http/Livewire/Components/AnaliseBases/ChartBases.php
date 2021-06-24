<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartBases extends Component
{
    public $series = [];
    public $categories = [];

    protected $listeners = ['emitFiltros' => 'update'];

    public function mount()
    {
        $teste = DB::select("CALL dw_atual.fat_persp(".Carbon::today()->year.",".Carbon::today()->month.", 'Base')");

        foreach ($teste as $t)
        {
            array_push($this->categories, $t->Base);
            array_push($this->series, intval($t->Receita));
        }
    }

    public function update($filtro)
    {
        $this->categories = [];
        $this->series = [];
        $teste = DB::select("CALL dw_atual.fat_persp(".$filtro['year'].",".$filtro['month'].", 'Base')");
        foreach ($teste as $t)
        {
            array_push($this->categories, $t->Base);
            array_push($this->series, intval($t->Receita));
        }
        $this->dispatchBrowserEvent('updateChart');
    }
    public function render()
    {
        return view('livewire.components.analise-bases.chart-bases');
    }
}
