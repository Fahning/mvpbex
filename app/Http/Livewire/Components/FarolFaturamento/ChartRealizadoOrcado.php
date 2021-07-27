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

    public function filtrar($filtros)
    {
        $this->year = $filtros['ano'];
        $faturamento = DB::select("call realizado_orcado(".$this->year.")");
        $this->formatData($faturamento);
        $this->dispatchBrowserEvent('atualizaChart');
    }

    public function formatData($faturamento){
        Carbon::setLocale('pt_BR');
        $this->data2 = [
            'mes'       => [],
            'receita'   => [],
            'meta'      => []
        ];
        foreach ($faturamento as $fat){
            array_push($this->data2['mes'], ucfirst(Carbon::create(0, $fat->mes)->monthName));
            array_push($this->data2['receita'], intval($fat->receita));
            array_push($this->data2['meta'], intval($fat->meta));
        }
    }

    public function render()
    {
        return view('livewire.components.farol-faturamento.chart-realizado-orcado');
    }
}
