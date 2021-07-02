<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Indicadores extends Component
{

    public $indicators;
    protected $listeners = ['emitFiltros' => 'filtrar'];
    public function mount()
    {
        $indicators = DB::select("CALL faturamento_farol(2021,".Carbon::today()->month.")");
        if(!empty($indicators)){
            $this->indicators = (array)$indicators[0];
        }else{
            $this->indicators = [];
        }
    }


    public function filtrar($filtros)
    {
        $indicators = DB::select("CALL faturamento_farol(".$filtros['year'].",".$filtros['month'].")");

        if(!empty($indicators)){
            $indicators = (array)$indicators[0];
        }else{
            $this->indicators = [];
        }
        $this->indicators['Receita'] = $indicators['Receita'];
        if($filtros['month'] == Carbon::today()->month){
            $this->indicators['Meta Acumulada'] = $indicators['Meta Acumulada'];
        }else{
            unset($this->indicators['Meta Acumulada']);
        }
        $this->indicators['Meta'] = $indicators['Meta'];
        $this->indicators['Média Diária'] = $indicators['Média Diária'];
        $this->indicators['Desvio'] = $indicators['Desvio'];
        $this->indicators['Desvio (R$)'] = $indicators['Desvio (R$)'];
    }

    public function render()
    {
        return view('livewire.components.indicadores');
    }
}
