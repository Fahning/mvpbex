<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaBases extends Component
{
    public $tableMetaBases;
    public $year = 2021;
    public $month = 6;
    public function render()
    {
        $this->tableMetaBases = DB::select("call dw_atual.tabelas_filtros(".$this->year.", ".$this->month.",'Base')");
        return view('livewire.components.analise-bases.table-meta-bases');
    }
}
