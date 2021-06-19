<?php

namespace App\Http\Livewire\Components\Menus;

use App\Models\Insights;
use Livewire\Component;

class ButtonInsights extends Component
{
    public $insights;

    public function abreModal($id){
        $this->emit('mostraModal', $id);
    }
    public function render()
    {
        $this->insights = Insights::where('status', 0)->get();

        return view('livewire.components.menus.button-insights');
    }
}
