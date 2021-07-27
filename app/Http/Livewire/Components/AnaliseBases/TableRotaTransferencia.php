<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRotaTransferencia extends Component
{
    public $tableRotaTransferencia;
    public $year;
    public $month;
    public $maiorReceita;
    public $maiorCTRC;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRotaTransferencia = DB::select("call tabela_receita_rota(".$this->year.", ".$this->month.",'Transferencia')");
        foreach ($this->tableRotaTransferencia as $t){
            if($this->maiorCTRC < $t->{"Qtde CTRC"}){
                $this->maiorCTRC = $t->{"Qtde CTRC"};
            }

            if($this->maiorReceita < $t->Receita){
                $this->maiorReceita = $t->Receita;
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $this->tableRotaTransferencia = DB::select("CALL tabela_receita_rota(".$this->year.", ".$this->month.",'Transferencia')");
        foreach ($this->tableRotaTransferencia as $t){
            if($this->maiorCTRC < $t->{"Qtde CTRC"}){
                $this->maiorCTRC = $t->{"Qtde CTRC"};
            }

            if($this->maiorReceita < $t->Receita){
                $this->maiorReceita = $t->Receita;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rota-transferencia');
    }
}
