<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkBases extends Component
{
    public $tableRpkBases;
    public $year;
    public $month;
    public $maior = 0;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRpkBases = DB::table('v_indic_base')
            ->select('Base', 'TKM', 'RPK', '% Frete/Valor Mercadoria', 'Qtde CTRC')
            ->where('ano', $this->year)
            ->where('mes', $this->month)
            ->get();
        foreach ($this->tableRpkBases as $t){
            if($this->maior < $t->{'Qtde CTRC'}){
                $this->maior = $t->{'Qtde CTRC'};
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $this->tableRpkBases = DB::table('v_indic_base')
            ->select('Base', 'TKM', 'RPK', '% Frete/Valor Mercadoria', 'Qtde CTRC')
            ->where('ano', $this->year)
            ->where('mes', $this->month)
            ->when($filtro['searchBase'], function ($query) use ($filtro) {
                $query->whereIn('Base', $filtro['searchBase']);
            })
            ->get();
        foreach ($this->tableRpkBases as $t){
            if($this->maior < $t->{'Qtde CTRC'}){
                $this->maior = $t->{'Qtde CTRC'};
            }

        }
    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rpk-bases');
    }
}

