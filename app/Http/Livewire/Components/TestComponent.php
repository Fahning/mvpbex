<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class TestComponent extends Component
{

    public $teste = "Fahning";
    public function render()
    {

        return view('livewire.components.test-component');
    }
}
