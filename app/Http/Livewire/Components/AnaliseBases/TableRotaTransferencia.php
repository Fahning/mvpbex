<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRotaTransferencia extends Component
{
    public $tableRotaTransferencia;
    public $year = 2021;
    public $month = 6;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->tableRotaTransferencia = DB::select("call dw_atual.tabela_receita_rota(".$this->year.", ".$this->month.",'Transferencia')");
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->tableRotaTransferencia = DB::select("CALL dw_atual.tabela_receita_rota(".$this->year.", ".$this->month.",'Transferencia')");

    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rota-transferencia');
    }
}
