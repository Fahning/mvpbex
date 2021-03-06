<?php

namespace App\Http\Livewire\Components\FarolFaturamento;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartFaturamento extends Component
{
    public $data;
    protected $hide = false;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $faturamento = DB::select("CALL faturamento_dia(".Carbon::today()->year.",".Carbon::today()->month.")");
        $this->fatoraFaturamento($faturamento);
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
            $faturamento = DB::select("CALL faturamento_dia(" . $filtro['ano'] . "," . $filtro['mes'] . ")");
            $this->fatoraFaturamento($faturamento);
            $this->dispatchData();
        }
    }

    private function fatoraFaturamento($faturamento)
    {
        $this->data = ['day'=> [], 'value' => []];
        $faturamento = (array)$faturamento;
        foreach ($faturamento as $fat){
            array_push($this->data['day'], $fat->Dia);
            array_push($this->data['value'], floatval($fat->Receita));
        }
    }

    public function dispatchData()
    {
        $this->dispatchBrowserEvent('renderChartFaturamento',[
            'categories' => $this->data['day'],
            'series' => $this->data['value']
        ]);
    }

    public function render()
    {
        if($this->hide) {
            return <<<'blade'
                <span></span>
            blade;
        }else {
            return view('livewire.components.farol-faturamento.chart-faturamento');
        }
    }
}
