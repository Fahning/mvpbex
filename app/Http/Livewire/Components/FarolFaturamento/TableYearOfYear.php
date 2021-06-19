<?php

namespace App\Http\Livewire\Components\FarolFaturamento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableYearOfYear extends Component
{
    public function render()
    {
        $table = DB::select("SELECT * FROM dw_atual.yoy_sal");

        return view('livewire.components.farol-faturamento.table-year-of-year', compact('table'));
    }
}
