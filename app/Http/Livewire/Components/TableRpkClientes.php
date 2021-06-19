<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkClientes extends Component
{
    public $tableRpkClientes;
    public $year = 2021;
    public $month = 6;
    public function render()
    {
        $this->tableRpkClientes = DB::select("call dw_atual.tabela_persp_filtros(".$this->year.", ".$this->month.", 'Cliente')");
        return view('livewire.components.table-rpk-clientes');
    }
}
