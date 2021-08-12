<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRotaEntrega extends Component
{
    public $tableRotaEntrega;
    public  $year;
    public  $month;
    public $maiorReceita;
    public $maiorCTRC;
    public $rotaEntrega;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRotaEntrega = DB::table('v_receita_entrega_new')
            ->select('Rota', 'Peso', 'Receita', 'Qte CTRC', 'Volumes')
            ->where('Ano', $this->year)
            ->where('M', $this->month)
            ->orderBy('Receita', 'desc')
            ->get();
        foreach ($this->tableRotaEntrega as $t){
            if($this->maiorCTRC < $t->{"Qte CTRC"}){
                $this->maiorCTRC = $t->{"Qte CTRC"};
            }

            if($this->maiorReceita < $t->Receita){
                $this->maiorReceita = $t->Receita;
            }
        }
    }

    public function filtroRota()
    {
        $this->tableRotaEntrega = DB::table('v_receita_entrega_new')
            ->select('Rota', 'Peso', 'Receita', 'Qte CTRC', 'Volumes')
            ->where('Ano', $this->year)
            ->where('M', $this->month)
            ->when($this->rotaEntrega, function ($query) {
                $query->where('Rota', 'LIKE', "%". $this->rotaEntrega ."%");
            })
            ->orderBy('Receita', 'desc')
            ->get();
    }

    public function filtrar($filtro)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;
        $this->tableRotaEntrega = DB::table('v_receita_entrega_new')
            ->select('Rota', 'Peso', 'Receita', 'Qte CTRC', 'Volumes')
            ->where('Ano',  $filtros['ano'])
            ->where('M',  $filtros['mes'])
            ->orderBy('Receita', 'desc')
            ->get();
        foreach ($this->tableRotaEntrega as $t){
            if($this->maiorCTRC < $t->{"Qte CTRC"}){
                $this->maiorCTRC = $t->{"Qte CTRC"};
            }

            if($this->maiorReceita < $t->Receita){
                $this->maiorReceita = $t->Receita;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rota-entrega');
    }
}
