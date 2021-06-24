<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TabelaDistribuicao extends Component
{
    public $tableDistribuicao;
    public $year;
    public $month;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableDistribuicao = DB::select("call dw_atual.dist_cargas(".$this->year.", ".$this->month.",'Peso')");
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->tableDistribuicao = DB::select("CALL dw_atual.dist_cargas(".$this->year.", ".$this->month.",'Peso')");
    }

    public function render()
    {
        return view('livewire.components.analise-clientes.tabela-distribuicao');
    }
}
