<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkSegmento extends Component
{
    public $table;
    public $year;
    public $month;
    public $maior = 0;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->table = DB::table('v_indic_segmento')
            ->select('Segmento', 'TKM', 'RPK', '% Frete/Valor Mercadoria', 'Qtde CTRC')
            ->where('ano', $this->year)
            ->where('mes', $this->month)
            ->orderBy('Qtde CTRC', 'desc')
            ->get();
        foreach ($this->table as $t){
            if($this->maior < $t->{"Qtde CTRC"}){
                $this->maior = $t->{"Qtde CTRC"};
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $this->table = DB::table('v_indic_segmento')
            ->select('Segmento', 'TKM', 'RPK', '% Frete/Valor Mercadoria', 'Qtde CTRC')
            ->where('ano', $this->year)
            ->where('mes', $this->month)
            ->when($filtro['searchSegmentos'], function($query) use($filtro) {
                $query->whereIn('Segmento', $filtro['searchSegmentos']);
            })
            ->orderBy('Qtde CTRC', 'desc')
            ->get();

        foreach ($this->table as $t){
            if($this->maior < $t->{"Qtde CTRC"}){
                $this->maior = $t->{"Qtde CTRC"};
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-segmento.table-rpk-segmento');
    }
}
