<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Indicadores extends Component
{

    public $indicators;
    protected $hide = false;
    protected $listeners = ['filtros' => 'filtrar'];
    public function mount()
    {
        $indicators = DB::select("CALL faturamento_farol(".Carbon::today()->year.",".Carbon::today()->month.")");

        if(!empty($indicators)){
            $this->indicators = (array)$indicators[0];
        }
        $this->indicators['Meta'] = $this->indicators['Meta'] ?? 0;
        $this->indicators['Média Diária'] = $this->indicators['Média Diária'] ?? 0;
        $this->indicators['Desvio'] = $this->indicators['Desvio'] ?? 0;
        $this->indicators['Desvio (R$)'] = $this->indicators['Desvio (R$)'] ?? 0;
    }


    public function filtrar($filtro)
    {
        if(
            !is_null($filtro['searchBase'])
            || !is_null($filtro['searchSegmentos'])
            || !is_null($filtro['searchCliente'])
        ){
            $this->hide = true;
        }else {
            $filtro['ano'] = $filtro['ano'] ?? Carbon::today()->year;
            $filtro['mes'] = $filtro['mes'] ?? Carbon::today()->month;
            $indicators = DB::select("CALL faturamento_farol(" . $filtro['ano'] . "," . $filtro['mes'] . ")");
            if (!empty($indicators)) {
                $indicators = (array)$indicators[0];
                $this->indicators['Receita'] = $indicators['Receita'] ?? 0;
                if ($filtro['mes'] == Carbon::today()->month) {
                    $this->indicators['Meta Acumulada'] = $indicators['Meta Acumulada'];
                } else {
                    unset($this->indicators['Meta Acumulada']);
                }
            }
            $this->indicators['Meta'] = $indicators['Meta'] ?? 0;
            $this->indicators['Média Diária'] = $indicators['Média Diária'] ?? 0;
            $this->indicators['Desvio'] = $indicators['Desvio'] ?? 0;
            $this->indicators['Desvio (R$)'] = $indicators['Desvio (R$)'] ?? 0;
        }
    }

    public function render()
    {
        if($this->hide) {
            return <<<'blade'
                <span></span>
            blade;
        }else {
            return view('livewire.components.indicadores');
        }
    }
}
