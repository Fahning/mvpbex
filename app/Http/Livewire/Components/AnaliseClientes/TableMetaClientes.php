<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaClientes extends Component
{
    public $table;
    public $month = 6;
    public $year = 2021;
    public function render()
    {
        $this->table = DB::select("call dw_atual.tabela_segmento(".Carbon::today()->year.", ".Carbon::today()->month.")");
        return view('livewire.components.analise-clientes.table-meta-clientes');
    }
}
