<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkClientes extends Component
{
    public $tableRpkClientes;
    public $year;
    public $month;

    public $maior = 0;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRpkClientes = DB::select("call tabela_persp_filtros(".$this->year.", ".$this->month.", 'Cliente')");
        foreach ($this->tableRpkClientes as $t){
            if($this->maior < $t->{"Qtde CTRC"}){
                $this->maior = $t->{"Qtde CTRC"};
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->tableRpkClientes = DB::select("call tabela_persp_filtros(".$this->year.", ".$this->month.", 'Cliente')");
    }

    public function render()
    {

        return view('livewire.components.analise-clientes.table-rpk-clientes');
    }
}
