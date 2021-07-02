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
        $this->table = DB::select("call calc_meta_base(".$this->year.", ".$this->month.")");
        foreach ($this->table as $t){
            $t->Meta = floatval($t->peso_base) * floatval($media[0]->vMedia);
            unset($t->peso_base);
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['year'];
        $this->month = $filtro['month'];
        $this->table = DB::select("call tabela_fat_segmento(".$this->year.", ".$this->month.")");
    }

    public function render()
    {

        return view('livewire.components.analise-segmento.table-meta-segmento');
    }
}
