<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Farol extends Component
{
    protected $farol;

    public function render()
    {
        $farol = DB::select("SELECT desvio FROM dw_atual.desvio_meta WHERE mes = 6");
        $farol = $farol[0]->desvio;
        return view('livewire.components.farol', compact('farol'));
    }
}
