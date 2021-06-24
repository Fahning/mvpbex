<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRotaEntrega extends Component
{
    public $tableRotaEntrega;
    public  $year = 2021;
    public  $month = 6;

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->tableRotaEntrega = DB::select("call dw_atual.tabela_receita_rota(".$this->year.", ".$this->month.",'Entrega')");
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->tableRotaEntrega = DB::select("CALL dw_atual.tabela_receita_rota(".$this->year.", ".$this->month.",'Entrega')");
    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rota-entrega');
    }
}
