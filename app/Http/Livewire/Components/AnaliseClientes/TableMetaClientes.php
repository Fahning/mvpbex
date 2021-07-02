<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaClientes extends Component
{
    public $table;
    public $month;
    public $year;
    public $maior = 0;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->table = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Cliente')");
        foreach ($this->table as $t){
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->table = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Cliente')");
        foreach ($this->table as $t){
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-clientes.table-meta-clientes');
    }
}
