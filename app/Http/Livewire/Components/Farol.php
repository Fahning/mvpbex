<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Farol extends Component
{
    public $farol;

    protected $listeners = ['emitFiltros' => 'filtrar'];
    public function mount()
    {
        $farol = DB::select("CALL farol(".Carbon::today()->year.",".Carbon::today()->month.")");
        $farol = (array)$farol[0]->vMensagem;
        $this->farol = $farol[0];

    }

    public function filtrar($filtros)
    {
        $farol = DB::select("CALL farol(".$filtros['year'].",".$filtros['month'].")");
        $farol = (array)$farol[0]->vMensagem;
        $this->farol = $farol[0];
    }

    public function render()
    {
        return view('livewire.components.farol');
    }
}
