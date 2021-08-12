<?php

namespace App\Http\Livewire;

use App\Models\Insight;
use App\Models\Insights;
use Livewire\Component;

class Financeiro extends Component
{


//    protected $listeners = ['filtros'];
//
//
//    public function filtros($filtros)
//    {
//        dd($filtros);
//    }
    public function render()
    {
        return view('livewire.financeiro');
    }
}
