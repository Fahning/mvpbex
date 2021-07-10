<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeCustos;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cards extends Component
{
    public function render()
    {
        return view('livewire.components.operacional.analise-de-custos.cards',[
            'cards' =>DB::table('conhecimento_baixa', 'cb')
                ->leftJoin('movromaneio',function($join) {
                    $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'movromaneio.ctrb');
                })
                ->leftJoin(DB::raw("(SELECT ctrc, SUM(cubagem) as cubagem_total FROM notas WHERE cubagem <> 0 GROUP BY ctrc) AS cub"),
                    'cb.ctrc', '=', 'cub.ctrc')
                ->leftJoin('tabela_ctes as nf', 'cb.ctrc', '=', 'nf.ctrc' )
                ->selectRaw("SUM((movromaneio.valor_pagar/movromaneio.peso_ctrc)*(cb.pesocalc)) as 'Custo Peso Total',
                                      SUM((movromaneio.valor_pagar/cub.cubagem_total)*(nf.cubagem)) as 'Custo Cubagem Total'")
                ->first(),
            'faturamento' => DB::select('SELECT SUM(faturamento) as faturamento FROM (
	SELECT
        con.data_emissao as emissao,
        SUM(DISTINCT rom.frete_ctrc) AS faturamento
    FROM romaneio as rom
    LEFT JOIN conhecimento as con
    ON rom.ctrc = con.ctrc
    GROUP BY rom.ctrc) as fat'),
            'ctrb_os' => DB::table('conhecimento_baixa')
                ->selectRaw('count(0) as total')
                ->whereNull('ctrb_os')
                ->orWhere('ctrb_os', '')
                ->first()
        ]);
    }
}
