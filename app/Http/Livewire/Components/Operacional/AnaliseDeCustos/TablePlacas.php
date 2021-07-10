<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeCustos;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TablePlacas extends Component
{
    public $tipoTable = 'cb.placa';

    public function render()
    {
        return view('livewire.components.operacional.analise-de-custos.table-placas'
            , [
            'table' => DB::table('conhecimento_baixa', 'cb')
                ->leftJoin('movromaneio as mv',function($join) {
                    $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'mv.ctrb');
                })
                ->leftJoin(DB::raw("(SELECT cb.unidade, cb.ctrb_os, SUM(nf.cubagem) as cubagem_total FROM notas nf LEFT JOIN conhecimento_baixa cb ON nf.ctrc = cb.ctrc GROUP BY cb.unidade, cb.ctrb_os) as cub"), function($q) {
                    $q->on('cb.ctrb_os', '=', 'cub.ctrb_os');
                    $q->on('cb.unidade', '=', 'cub.unidade');
                })
                ->leftJoin('notas as nf', 'cb.ctrc', '=', 'nf.ctrc')
                ->selectRaw($this->tipoTable.", (mv.valor_pagar*100)/mv.frete_ctrc as 'Custo % Frete', SUM(cb.pesocalc) as Peso, SUM(nf.cubagem) as Cubagem, SUM(cb.qtdvol) as 'Qtd Volumes', SUM(cb.valmerc) as '(R$) Mercadoria', SUM(cb.valfrete) as '(R$) Frete', SUM((mv.valor_pagar/mv.peso_ctrc)*(cb.pesocalc)) as 'Custo (KG)', SUM((mv.valor_pagar/cub.cubagem_total)*(nf.cubagem)) as 'Custo (M3)'")
                ->where('cb.ctrb_os', '<>', '')->where('cb.tipobaixa', 'C')
                ->groupBy($this->tipoTable)
                ->take(1000)->get()
        ]
        );
    }
}
