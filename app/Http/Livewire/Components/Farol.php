<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Farol extends Component
{
    public $farol;
    protected $hide = false;

    protected $listeners = ['filtros' => 'filtrar'];
    public function mount()
    {
        $farol = DB::select("CALL farol(".Carbon::today()->year.",".Carbon::today()->month.")");
        $farol = (array)$farol[0]->vMensagem;
        $this->farol = $farol[0];

    }

    public function filtrar($filtro)
    {
        if(
               !is_null($filtro['searchBase'])
            || !is_null($filtro['searchSegmentos'])
            || !is_null($filtro['searchCliente'])
        ){
            $this->hide = true;
        }else{
            $filtro['ano'] = $filtro['ano'] ?? Carbon::today()->year;
            $filtro['mes'] = $filtro['mes'] ?? Carbon::today()->month;
            $farol = DB::select("CALL farol(".$filtro['ano'].",".$filtro['mes'].")");
            $farol = (array)$farol[0]->vMensagem;
            $this->farol = $farol[0];
        }
    }

    public function render()
    {
        if($this->hide) {
            return <<<'blade'
                <span></span>
            blade;
        }else{
            return view('livewire.components.farol');
        }

    }
}
