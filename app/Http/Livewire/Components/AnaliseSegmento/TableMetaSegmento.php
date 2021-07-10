<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaSegmento extends Component
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
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        $this->table = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Segmento')");
        foreach ($this->table as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia);
            unset($t->{'Fator Peso'});
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        $this->table = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Segmento')");
        foreach ($this->table as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia);
            unset($t->{'Fator Peso'});
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function render()
    {

        return view('livewire.components.analise-segmento.table-meta-segmento');
    }
}
