<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TabelaOverview extends Component
{
    public $tabelaOverview;

    public function mount()
    {
        $this->tabelaOverview = DB::table('bexsal_bdsal.tabela_ctes', 'nf')
            ->selectRaw("
                        cl.ano AS Ano,
                        cl.mesnome AS Mês,
                        SUM(nf.val_frete) AS Receita,
                        (CASE
                            WHEN
                                ((nf.mes = MONTH(CURDATE()))
                                    AND (nf.ano = YEAR(CURDATE())))
                            THEN
                                (SUM(nf.val_frete) / cl.dias_uteis_hoje)
                            ELSE (SUM(nf.val_frete) / cl.dias_uteis)
                        END) AS 'Frete/Dia',
                        SUM(nf.qtd_volumes) AS Volumes,
                        SUM(nf.cubagem) AS Cubagem,
                        SUM(nf.peso_real_kg) AS Peso,
                        SUM(nf.val_mercadoria) AS 'Valor Mercadoria',
                        (CASE
                            WHEN
                                ((nf.mes = MONTH(CURDATE()))
                                    AND (nf.ano = YEAR(CURDATE())))
                            THEN
                                (SUM(nf.val_mercadoria) / cl.dias_uteis_hoje)
                            ELSE (SUM(nf.val_mercadoria) / cl.dias_uteis)
                        END) AS 'Valor Merc/Dia'
            ")
            ->leftJoin('bexsal_bdsal.calendar_dias_uteis as cl', function ($join){
                $join->on('nf.ano', '=', 'cl.ano');
                $join->on('nf.mes', '=', 'cl.mes');
            })
            ->leftJoin('bexsal_bdsal.relacao_unidade_local rcl', 'rcl.sigla', '=', 'nf.und_emissora')
            ->groupBy('nf.ano','nf.mes')
            ->orderBy('nf.mes', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.components.movimentacoes.tabela-overview');
    }
}
