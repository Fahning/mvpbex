<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TabelaChegada extends Component
{
    public $tabelaChegada;

    public function mount()
    {
        $this->tabelaChegada = DB::table('bexsal_reports.tabela_chegada_final')
            ->get();
    }
    public function render()
    {
        return view('livewire.components.movimentacoes.tabela-chegada');
    }
}
