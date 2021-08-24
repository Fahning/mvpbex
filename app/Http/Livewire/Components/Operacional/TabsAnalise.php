<?php

namespace App\Http\Livewire\Components\Operacional;

use Livewire\Component;

class TabsAnalise extends Component
{
    public $tab = 2;

    public function tab($tab)
    {
        $this->tab = $tab;
    }
    public function render()
    {
        return view('livewire.components.operacional.tabs-analise');
    }
}
