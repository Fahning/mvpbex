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
    public $rota;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRotaTransferencia = DB::table("v_receita_transf_new")
                    ->select( "Cidade Origem", "Cidade Destino", "Receita", "Quantidade CTRC as Qtde CTRC", "Volumes", "Peso")
                    ->where('Ano', $this->year)
                    ->where('M', $this->month)
                    ->get();
        foreach ($this->tableRotaTransferencia as $t){
            if($this->maiorCTRC < $t->{"Qtde CTRC"}){
                $this->maiorCTRC = $t->{"Qtde CTRC"};
            }

            if($this->maiorReceita < $t->Receita){
                $this->maiorReceita = $t->Receita;
            }
        }
    }

    public function filtrarRota()
    {
        $this->tableRotaTransferencia = DB::table("v_receita_transf_new")
            ->select( "Cidade Origem", "Cidade Destino", "Receita", "Quantidade CTRC as Qtde CTRC", "Volumes", "Peso")
            ->where('Ano', $this->year)
            ->where('M', $this->month)
            ->when($this->rota, function ($query){
                $query->where('Cidade Origem', 'LIKE', '%' . $this->rota . '%');
            })
        ->get();
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $this->tableRotaTransferencia = DB::table("v_receita_transf_new")
            ->select( "Cidade Origem", "Cidade Destino", "Receita", "Quantidade CTRC as Qtde CTRC", "Volumes", "Peso")
            ->where('Ano', $this->year)
            ->when($this->rota, function ($query){
                $query->where('Cidade Origem', 'LIKE', '%' . $this->rota . '%');
            })
            ->where('M', $this->month)
            ->get();

    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rota-transferencia');
    }
}
