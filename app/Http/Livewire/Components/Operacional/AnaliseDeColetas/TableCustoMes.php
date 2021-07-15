<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeColetas;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableCustoMes extends Component
{
    public function render()
    {
        return view('livewire.components.operacional.analise-de-coletas.table-custo-mes',[
            'table' =>  DB::table('conhecimento_baixa', 'cb')
        ->leftJoin('movromaneio as mv',function($join) {
            $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'mv.ctrb');
        })
        ->leftJoin(DB::raw("(SELECT cb.unidade, cb.ctrb_os, SUM(nf.cubagem) as cubagem_total FROM notas nf LEFT JOIN conhecimento_baixa cb ON nf.ctrc = cb.ctrc GROUP BY cb.unidade, cb.ctrb_os) as cub"), function($q) {
            $q->on('cb.ctrb_os', '=', 'cub.ctrb_os');
            $q->on('cb.unidade', '=', 'cub.unidade');
        })
        ->leftJoin('tabela_ctes as nf', 'cb.ctrc', '=', 'nf.ctrc')
        ->selectRaw("YEAR(nf.data_emissao) as Ano,
                                MONTH(nf.data_emissao) as Mês,
                                SUM((mv.valor_pagar/mv.peso_ctrc)*(cb.pesocalc))/SUM(nf.val_frete)*100 as '% Custo (KG)',
                                SUM((mv.valor_pagar/cub.cubagem_total)*(nf.cubagem))/SUM(nf.val_frete)*100 as '% Custo (M3)'")
        ->whereNotNull('nf.data_emissao')->where('cb.tipobaixa', 'C')
        ->groupBy('Mês', 'Ano')
        ->orderBy('nf.data_emissao', 'desc')->get()
        ]);
    }
}
