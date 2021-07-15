<?php

namespace App\Http\Livewire\Components\Operacional;

use Livewire\Component;

class Filtros extends Component
{

    public $filtros = [
        'dataStart' => null,
        'dataEnd' => null,
        'ano' => null,
        'mes' => null,
        'trimestre' => null,
    ];

    public function filtrar()
    {
        $this->emit('filtros', $this->filtros);
    }

    public function render()
    {
        return view('livewire.components.operacional.filtros');
    }
}
