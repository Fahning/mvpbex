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
    public $persp;

    protected $listeners = ['filtros' => 'filtrar'];

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
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $this->tableDistribuicao = DB::select("CALL dist_cargas(".$this->year.", ".$this->month.",'Peso')");
        foreach ($this->tableDistribuicao as $t){
            if($this->maior < $t->{"Qtde de CTRC"}){
                $this->maior = $t->{"Qtde de CTRC"};
            }
        }
    }

    public function perspectiva()
    {
        $this->tableDistribuicao = DB::select("CALL dist_cargas(".$this->year.", ".$this->month.",'{$this->persp}')");
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
