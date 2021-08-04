<?php

namespace App\Http\Livewire\Components\FarolFaturamento;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartFaturamento extends Component
{
    public $data;
    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $faturamento = DB::select("CALL faturamento_dia(".Carbon::today()->year.",".Carbon::today()->month.")");
        $this->fatoraFaturamento($faturamento);
    }

    public function filtrar($filtros)
    {
        $faturamento = DB::select("CALL faturamento_dia(".$filtros['ano'].",".$filtros['mes'].")");
        $this->fatoraFaturamento($faturamento);
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
        return view('livewire.components.farol-faturamento.chart-faturamento');
    }
}
