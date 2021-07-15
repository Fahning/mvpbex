<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeEntregas;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRotas extends Component
{
    public function render()
    {
        return view('livewire.components.operacional.analise-de-entregas.table-rotas', [
            'tableRotas' =>DB::table('conhecimento_baixa', 'cb')
            ->leftJoin('movromaneio',function($join) {
                    $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'movromaneio.ctrb');
            })
            ->leftJoin(DB::raw("(SELECT ctrc, SUM(cubagem) as cubagem_total FROM notas WHERE cubagem <> 0 GROUP BY ctrc) AS cub"),
                'cb.ctrc', '=', 'cub.ctrc')
            ->leftJoin('notas as nf', 'cb.ctrc', '=', 'nf.ctrc' )
            ->selectRaw("IF(cb.ctrb_os <> '', CONCAT(cb.unidade,cb.ctrb_os), '') as OS, cb.ctrc, cb.placa as placa_veiculo, cb.databaixa as data_baixa, cb.setor as rota, cb.pesocalc as peso, nf.cubagem, cb.qtdvol as qtd_volumes, cb.valmerc as valor_merc, cb.valfrete as frete, IF(cb.romaneio <> '0-0', CONCAT(cb.unidade,cb.romaneio), '') as num_romaneio, cb.unidade, cb.tipobaixa, cb.nf,(movromaneio.valor_pagar/movromaneio.peso_ctrc)*(cb.pesocalc) as custo_peso, (movromaneio.valor_pagar/cub.cubagem_total)*(nf.cubagem) as custo_cubagem")
            ->first()
        ]);
    }
}
