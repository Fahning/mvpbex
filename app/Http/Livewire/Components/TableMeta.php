<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMeta extends Component
{
    public $table;
    public $year = 2021;
    public $month = 6;
    public function render()
    {
        $this->table = DB::select("call dw_atual.tabela_fat_segmento(".$this->year.", ".$this->month.")");
        return view('livewire.components.table-meta');
    }
}
