<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkBases extends Component
{
    public $tableRpkBases;
    public $year = 2021;
    public $month = 6;

    public function render()
    {
        $this->tableRpkBases = DB::select("call dw_atual.tabela_persp_filtros(".$this->year.", ".$this->month.", 'Base')");
        return view('livewire.components.table-rpk-bases');
    }
}
