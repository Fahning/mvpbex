<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartClientes extends Component
{
    public $chartClientes;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount() {
        $chartClientes = DB::select("call dw_atual.fat_persp(".Carbon::today()->year.",".Carbon::today()->subMonth()->month.", 'Cliente')");
        $this->fatoraClientes($chartClientes);
    }

    public function filtrar($filtros)
    {
        dd($filtros);
//        $data = DB::select("call dw_atual.fat_persp(".$filtros['year'].",".$filtros['month'].", 'Segmento')");
//        $this->fatoraClientes($data);
    }

    public function fatoraClientes($chartClientes){
        $this->chartClientes = [
            'categories' => [],
            'series' => []
        ];
        foreach ($chartClientes as $d){
            array_push($this->chartClientes['categories'], $d->Cliente);
            array_push($this->chartClientes['series'], intval($d->Receita));
        }
    }
    public function render()
    {
        return view('livewire.components.chart-clientes');
    }
}
