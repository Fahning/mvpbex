<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeCustos;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoCustos extends Component
{
    public $dataGraf;

    public function formatData($faturamento){
        $data = [
            'databaixa'       => [],
            'faturamento'   => [],
            'custo_peso'   => [],
            'custo_cubagem'      => []
        ];
        foreach ($faturamento as $fat){
            array_push($data['databaixa'], Carbon::create($fat->ano, $fat->mes)->format('m/Y'));
            array_push($data['faturamento'], floatval($fat->faturamento));
            array_push($data['custo_peso'], floatval($fat->custo_peso));
            array_push($data['custo_cubagem'], floatval($fat->custo_cubagem));
        }
        return $data;
    }
    public function render()
    {
        $data = DB::table('conhecimento_baixa', 'cb')
            ->leftJoin('movromaneio',function($join) {
                $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'movromaneio.ctrb');
            })
            ->leftJoin(DB::raw("(SELECT cb.unidade, cb.ctrb_os, SUM(nf.cubagem) as cubagem_total FROM notas nf LEFT JOIN conhecimento_baixa cb ON nf.ctrc = cb.ctrc GROUP BY cb.unidade, cb.ctrb_os) as cub"), function($q) {
                $q->on('cb.ctrb_os', '=', 'cub.ctrb_os');
                    $q->on('cb.unidade', '=', 'cub.unidade');
            })
            ->leftJoin('tabela_ctes as nf', 'cb.ctrc', '=', 'nf.ctrc')
            ->selectRaw('month(nf.data_emissao) as mes, year(nf.data_emissao) as ano, SUM(cb.valfrete) as faturamento, SUM((movromaneio.valor_pagar/movromaneio.peso_ctrc)*(cb.pesocalc)) as custo_peso, SUM((movromaneio.valor_pagar/cub.cubagem_total)*(nf.cubagem)) as custo_cubagem')
            ->where('cb.ctrb_os', '<>', '')->where('cb.tipobaixa', 'C')
            ->groupBy('mes', 'ano')
            ->orderBy('nf.data_emissao', 'ASC')
            ->take(1000)->get();
//        dd($data);
        $this->dataGraf = $this->formatData($data);
        return view('livewire.components.operacional.analise-de-custos.grafico-custos');
    }
}
