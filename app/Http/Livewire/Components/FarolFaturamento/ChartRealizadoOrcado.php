<?php

namespace App\Http\Livewire\Components\FarolFaturamento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartRealizadoOrcado extends Component
{
    public $year;
    public $data2;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $faturamento = DB::select("call realizado_orcado(".$this->year.")");
        $this->formatData($faturamento);
    }

    public function filtrar($filtro)
    {
        $filtro['ano'] = $filtro['ano'] ?? Carbon::today()->year;
        $faturamento = DB::select("call realizado_orcado(".$filtro['ano'].")");
        $this->formatData($faturamento);
        $this->dispatchDataRO();
    }

    private function formatData($faturamento){
        Carbon::setLocale('pt_BR');
        $this->data2 = [
            'mes'       => [],
            'receita'   => [],
            'meta'      => []
        ];
        foreach ($faturamento as $fat){
            array_push($this->data2['mes'], ucfirst(Carbon::create(0, $fat->mes)->monthName));
            array_push($this->data2['receita'], floatval($fat->receita));
            array_push($this->data2['meta'], floatval($fat->meta));
        }
    }

    public function dispatchDataRO()
    {
        $this->dispatchBrowserEvent('renderChartRO',[
            'categories' => $this->data2['mes'],
            'series' => $this->data2['receita'],
            'series2' => $this->data2['meta']
        ]);
    }

    public function render()
    {
        return view('livewire.components.farol-faturamento.chart-realizado-orcado');
    }
}
