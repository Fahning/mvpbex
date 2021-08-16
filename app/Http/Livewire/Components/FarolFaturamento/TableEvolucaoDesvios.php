<?php

namespace App\Http\Livewire\Components\FarolFaturamento;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableEvolucaoDesvios extends Component
{
    public $maior = 0;
    public $menor;
    public $table;
    protected $hide = false;

    protected $listeners = ['filtros' => 'filtrar'];


    public function mount()
    {
        $select = DB::raw("ano as Ano,
                mes as Mês,
                receita as Realizado,
                IF(mes = MONTH(CURRENT_DATE()) AND ano = YEAR(CURRENT_DATE()),
                meta_acumulada, meta) as Meta,
                desvio_abs as 'Desvio (R$)',
                desvio as 'Desvio (%)'");
        $this->table = DB::table("desvio_media_faturamento")
            ->select($select)
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();
        foreach ($this->table as $t){
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
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
            $select = DB::raw("ano as Ano,
                    mes as Mês,
                    receita as Realizado,
                    IF(mes = MONTH(CURRENT_DATE()) AND ano = YEAR(CURRENT_DATE()),
                    meta_acumulada, meta) as Meta,
                    desvio_abs as 'Desvio (R$)',
                    desvio as 'Desvio (%)'");
            $this->table = DB::table("desvio_media_faturamento")
                ->select($select)
                ->when($filtro['orderDesvios'], function ($query) use ($filtro) {
                    $query->orderBy('desvio', $filtro['orderDesvios'], 'desc');
                })
                ->when(!$filtro['orderDesvios'], function ($query) use ($filtro) {
                    $query->orderBy('ano', 'desc');
                    $query->orderBy('mes', 'desc');
                })
                ->get();

            foreach ($this->table as $t) {
                if ($this->maior < $t->Realizado) {
                    $this->maior = $t->Realizado;
                }
            }
        }
    }
    public function render()
    {
        if($this->hide) {
            return <<<'blade'
                <span></span>
            blade;
        }else {
            return view('livewire.components.farol-faturamento.table-evolucao-desvios');
        }
    }
}
