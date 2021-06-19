<?php

namespace App\Http\Livewire\Components\Menus;

use App\Models\Insights;
use Livewire\Component;

class ModalInsight extends Component
{
    public $insight;

    protected $listeners = ['mostraModal'];

    public function mostraModal(Insights $insight) {
        $this->insight = $insight;

        $this->dispatchBrowserEvent('abreModal', ['abreModal' => true]);
    }
    public function render()
    {
        return view('livewire.components.menus.modal-insight');
    }
}
