<?php

namespace App\Http\Livewire\Components\FarolFaturamento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableEvolucaoDesvios extends Component
{
    public $maior = 0;
    public $menor;
    public function render()
    {
        $table = DB::select("CALL tabela_faturamentos()");
        foreach ($table as $t){
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
        return view('livewire.components.farol-faturamento.table-evolucao-desvios', compact('table'));
    }
}
