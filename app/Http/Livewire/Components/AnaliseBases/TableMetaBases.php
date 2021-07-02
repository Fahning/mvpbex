<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaBases extends Component
{
    public $tableMetaBases;
    public $year;
    public $month;
    public $maior = 0;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount(){
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableMetaBases = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Base')");
        foreach ($this->tableMetaBases as $t){
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->tableMetaBases = DB::select("CALL tabelas_filtros(".$this->year.", ".$this->month.",'Base')");
        foreach ($this->tableMetaBases as $t){
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-meta-bases');
    }
}
