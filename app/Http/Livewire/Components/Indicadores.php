<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Indicadores extends Component
{

    public $indicators;
    protected $listeners = ['filtros' => 'filtrar'];
    public function mount()
    {
        $indicators = DB::select("CALL faturamento_farol(".Carbon::today()->year.",".Carbon::today()->month.")");
        if(!empty($indicators)){
            $this->indicators = (array)$indicators[0];
        }
    }


    public function filtrar($filtros)
    {
        $indicators = DB::select("CALL faturamento_farol(".$filtros['ano'].",".$filtros['mes'].")");
        if(!empty($indicators)){
            $indicators = (array)$indicators[0];
            $this->indicators['Receita'] = $indicators['Receita'] ?? 0;
            if($filtros['mes'] == Carbon::today()->month){
                $this->indicators['Meta Acumulada'] = $indicators['Meta Acumulada'];
            }else{
                unset($this->indicators['Meta Acumulada']);
            }
        }
        $this->indicators['Meta'] = $indicators['Meta'] ?? 0;
        $this->indicators['Média Diária'] = $indicators['Média Diária'] ?? 0;
        $this->indicators['Desvio'] = $indicators['Desvio'] ?? 0;
        $this->indicators['Desvio (R$)'] = $indicators['Desvio (R$)'] ?? 0;
    }

    public function render()
    {
        return view('livewire.components.indicadores');
    }
}
