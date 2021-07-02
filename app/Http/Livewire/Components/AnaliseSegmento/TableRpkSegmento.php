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

    protected $listeners = ['emitFiltros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->table = DB::select("call tabela_segmento(".$this->year.", ".$this->month.")");
        foreach ($this->table as $t){
            if($this->maior < $t->{"Qtde CTRC"}){
                $this->maior = $t->{"Qtde CTRC"};
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->table = DB::select("call tabela_segmento(".$this->year.", ".$this->month.")");
    }

    public function render()
    {
        return view('livewire.components.analise-segmento.table-rpk-segmento');
    }
}
