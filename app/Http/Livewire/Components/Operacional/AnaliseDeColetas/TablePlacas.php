<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeColetas;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TablePlacas extends Component
{
    public $tipoTable = 'cb.placa';
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
            $this->tipoTable = 'cb.placa';
        }
        return view('livewire.components.operacional.analise-de-coletas.table-placas', [
            'tablePlacas' => DB::table('bexsal_reports.report_076', 'cb')
                ->join('bexsal_reports.report_073 as mv',function($join) {
                    $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'mv.ctrb');
                })
                ->leftJoin('bexsal_reports.cubagem_total_ctrb as cub', DB::raw('CONCAT(cb.unidade,cb.ctrb_os)'), '=', 'cub.ctrb')
                ->leftJoin('bexsal_reports.report_455 as nf', DB::raw("REPLACE(cb.ctrc,'/','')"), '=', 'nf.numero_ctrc')
                ->leftJoin('bexsal_bdsal.relacao_veiculos as veic', 'cb.placa', '=', 'veic.PLACA')
                ->selectRaw($this->tipoTable.",
                        (SUM(mv.valor_a_pagar) * 100)/SUM(mv.frete_ctrcs_ctrb_coleta_entrega) as 'Diária/Frete',
                        SUM(cb.peso_calculo) as Peso,
                        SUM(nf.cubagem_m3) as Cubagem,
                        SUM(cb.qtvol) as 'Qtd Volumes',
                        SUM(cb.val_merc) as '(R$) Mercadoria',
                        SUM(cb.vlr_frete) as '(R$) Frete',
                        SUM((mv.valor_a_pagar/mv.peso_ctrcs_ctrb_coleta_entrega)*(cb.peso_calculo)) as 'Custo (KG)',
                        SUM((mv.valor_a_pagar/cub.cubagem_total)*(nf.cubagem_m3)) as 'Custo (M3)'")
                ->where('cb.tipo_baixa', 'C')
                ->when($this->filtros['ano'], function ($query){
                    $query->where(function($query2){
                        $query2->whereYear('nf.data_emissao', $this->filtros['ano'])
                            ->orWhereYear('cb.data_baixa', $this->filtros['ano']);
                    });
                })
                ->when($this->filtros['mes'], function ($query) {
                    $query->where(function($query) {
                        $query->whereMonth('nf.data_emissao', $this->filtros['mes'])
                            ->orWhereMonth('cb.data_baixa', $this->filtros['mes']);
                    });
                })
                ->when($this->filtros['searchCliente'], function ($query) {
                    $query->where('nf.cliente_pagador', $this->filtros['searchCliente']);
                })
                ->when($this->filtros['searchBase'], function ($query) {
                    $query->whereIn('cb.unidade', $this->filtros['searchBase']);
                })
                ->when($this->filtros['searchSegmentos'], function ($query) {
                    $query->whereIn(DB::raw("IF(nf.segmento_pagador IS NOT NULL, nf.segmento_pagador, 'OUTROS')"), $this->filtros['searchSegmentos']);
                })
                ->groupBy($this->tipoTable)
                ->get()
        ]);
    }
}
