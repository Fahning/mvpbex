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

    protected $listeners = ['emitFiltros' => 'update'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $teste = DB::select("CALL fat_persp(".$this->year.",".$this->month.", 'Cliente')");
        foreach ($teste as $t)
        {
            array_push($this->categories, $t->Cliente);
            array_push($this->series, intval($t->Receita));
        }
    }

    public function update($filtro)
    {
        $this->categories = [];
        $this->series = [];
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $teste = DB::select("CALL fat_persp(".$this->year.",".$this->month.", 'Cliente')");
        foreach ($teste as $t)
        {
            array_push($this->categories, $t->Cliente);
            array_push($this->series, intval($t->Receita));
        }
        $this->dispatchBrowserEvent('updateChart');
    }
    public function render()
    {
        return view('livewire.components.analise-clientes.chart-clientes');
    }
}
