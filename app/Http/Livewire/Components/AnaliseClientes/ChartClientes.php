<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartClientes extends Component
{
    public $series = [];
    public $categories = [];

    protected $listeners = ['emitFiltros' => 'update'];

    public function mount()
    {
        $teste = DB::select("CALL dw_atual.fat_persp(".Carbon::today()->year.",".Carbon::today()->month.", 'Cliente')");
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
        $teste = DB::select("CALL dw_atual.fat_persp(".$filtro['year'].",".$filtro['month'].", 'Cliente')");
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
