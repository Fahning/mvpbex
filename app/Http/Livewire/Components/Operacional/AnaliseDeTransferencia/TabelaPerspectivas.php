<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeTransferencia;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TabelaPerspectivas extends Component
{
    public $tipoTable = "mf.placa_cavalo";
    public $filtros = [
        'dataStart' => null,
        'dataEnd' => null,
        'ano' => null,
        'mes' => null,
        'trimestre' => null,
        'searchCliente' => null,
        'searchBase' => null,
        'orderDesvios' => null,
        'searchSegmentos' => null
    ];


    protected $listeners = ['filtros' => 'filtrar'];


    public function filtrar($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;
        $this->filtros = $filtros;
    }

    public function render()
    {
        $this->filtros['ano'] = $this->filtros['ano'] ?? Carbon::today()->year;
        $this->filtros['mes'] = $this->filtros['mes'] ?? Carbon::today()->month;
        if($this->tipoTable == null){
            $tipoTable  = "mf.placa_cavalo";
        }elseif($this->tipoTable == 'rota'){
            $tipoTable  = "CONCAT(mf.und_origem, ' ➔ ',  mf.und_destino) as Rota";
        }else{
            $tipoTable = $this->tipoTable;
        }
        return view('livewire.components.operacional.analise-de-transferencia.tabela-perspectivas', [
            'tablePlacas' => DB::table('bexsal_reports.base_custos_transf', 'mf')
                ->selectRaw("{$tipoTable},
                            (SUM(mf.custo_peso)/SUM(mf.val_frete))*100 as 'Diária/Frete',
                            SUM(mf.peso_cal_kg) as 'Peso',
                            SUM(mf.cubagem) as 'Cubagem',
                            SUM(mf.qtd_volumes) as 'Volumes',
                            SUM(mf.val_mercadoria) as 'Valor Mercadoria',
                            SUM(mf.val_frete) as 'Frete',
                            SUM(mf.custo_peso) as 'Custo (KG)',
                            SUM(mf.custo_cubagem) as 'Custo (M3)'
                        ")
                ->when($tipoTable != "mf.placa_cavalo" || $tipoTable != "CONCAT(mf.und_origem, ' ➔ ',  mf.und_destino) as Rota", function ($query){
                    $query->leftJoin('bexsal_bdsal.relacao_veiculos as veic', 'mf.placa_cavalo', '=', 'veic.PLACA');
                })
                ->whereNotNull('mf.custo_peso')
                ->when($this->filtros['searchCliente'], function ($query) {
                    $query->where('mf.nome_pagador', $this->filtros['searchCliente']);
                })
                ->when($this->filtros['searchBase'], function ($query) {
                    $query->whereIn('mf.und_origem', $this->filtros['searchBase']);
                })
                ->when($this->filtros['searchSegmentos'], function ($query) {
                    $query->whereIn('mf.segmento', $this->filtros['searchSegmentos']);
                })
                ->when($tipoTable  == "CONCAT(mf.und_origem, ' ➔ ',  mf.und_destino) as Rota", function ($gb){
                    $gb->groupBy('Rota');
                })
                ->when($tipoTable  != "CONCAT(mf.und_origem, ' ➔ ',  mf.und_destino) as Rota", function ($gb) use($tipoTable){
                    $gb->groupBy($tipoTable);
                })
                ->get( )
        ]);
    }
}
