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

    protected $hide = false;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRotaTransferencia = DB::table("v_receita_transf_new")
                    ->select( "Cidade Origem", "Cidade Destino", "Receita", "Quantidade CTRC as Qtde CTRC", "Volumes", "Peso")
                    ->where('Ano', $this->year)
                    ->where('M', $this->month)
                    ->orderBy('Receita', 'desc')
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
            ->orderBy('Receita', 'desc')
            ->get();
    }

    public function filtrar($filtro)
    {
        if(
            !is_null($filtro['searchBase'])
            || !is_null($filtro['searchSegmentos'])
            || !is_null($filtro['searchCliente'])
        ){
            $this->hide = true;
        }else {
            $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
            $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;
            $this->tableRotaTransferencia = DB::table("v_receita_transf_new")
                ->select("Cidade Origem", "Cidade Destino", "Receita", "Quantidade CTRC as Qtde CTRC", "Volumes", "Peso")
                ->where('Ano', $filtros['ano'])
                ->when($this->rota, function ($query) {
                    $query->where('Cidade Origem', 'LIKE', '%' . $this->rota . '%');
                })
                ->where('M', $filtros['mes'])
                ->orderBy('Receita', 'desc')
                ->get();
        }

    }

    public function render()
    {
        if($this->hide) {
            return <<<'blade'
                <span></span>
            blade;
        }else {
            return view('livewire.components.analise-bases.table-rota-transferencia');
        }
    }
}
