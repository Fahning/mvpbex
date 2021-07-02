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
    public $maior = 0;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableDistribuicao = DB::select("call dist_cargas(".$this->year.", ".$this->month.",'Peso')");
        foreach ($this->tableDistribuicao as $t){
            if($this->maior < $t->{"Qtde de CTRC"}){
                $this->maior = $t->{"Qtde de CTRC"};
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->tableDistribuicao = DB::select("CALL dist_cargas(".$this->year.", ".$this->month.",'Peso')");
        foreach ($this->tableDistribuicao as $t){
            if($this->maior < $t->{"Qtde de CTRC"}){
                $this->maior = $t->{"Qtde de CTRC"};
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-clientes.tabela-distribuicao');
    }
}
