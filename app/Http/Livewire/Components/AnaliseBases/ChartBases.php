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

    protected $listeners = ['filtros' => 'update'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $teste = DB::select("CALL fat_persp(".$this->year.",".$this->month.", 'Base')");

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
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $teste = DB::select("CALL fat_persp(".$this->year.",".$this->month.", 'Base')");
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
