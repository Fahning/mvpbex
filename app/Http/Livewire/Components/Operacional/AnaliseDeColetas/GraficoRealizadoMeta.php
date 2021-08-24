<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeColetas;

use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoRealizadoMeta extends Component
{
    public $dataGraf;

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataCustMeta',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.report_076', 'cb')
            ->select(
                DB::raw('DATE_FORMAT(IF((con.data_emissao IS NOT NULL), con.data_emissao, cb.data_baixa), "%Y-%m") AS data_emis'),
                DB::raw('SUM((cb.peso_calculo * (mv.valor_a_pagar / mv.peso_ctrcs_ctrb_coleta_entrega))) AS custo_peso'),
                DB::raw('SUM((con.cubagem_m3 * (mv.valor_a_pagar / bexsal_reports.cub.cubagem_total)))AS custo_cubagem'),
                'mt.META_COLETA as meta'
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'bexsal_reports.cub.ctrb')
            ->join('dim_meta as mt', function ($join){
                $join->on(DB::raw("IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa))"), '=', 'mt.ANO');
                $join->on(DB::raw("IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))"), '=', 'mt.MES');
            })
            ->where('cb.tipo_baixa', '=', 'C')
            ->groupBy(DB::raw('IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa)), IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))'))
            ->get();
    }

    public function formatData($data)
    {
        $faturamento = TabelaCtes::select(
            DB::raw('SUM(val_frete) as Faturamento'),
            DB::raw('DATE_FORMAT(data_emissao,"%Y-%m") as data_emissao')
        )
            ->where('placa_coleta', '<>', 'ARMAZEM')
            ->whereIn('tipo_doc',['NORMAL','SUBC FORM CTRC'])
            ->groupBy('ano', 'mes')
            ->get();
        $dataGraf = [
            'data_emis' => [],
            'custo_cubagem' => [],
            'custo_peso' => [],
            'meta' => []
        ];
        foreach ($data as $value){
            $custo_p = 0;
            $custo_c = 0;
            foreach ($faturamento as $fat){
                if($value['data_emis'] == $fat->data_emissao){
                    $custo_p = $value['custo_peso'] / $fat->Faturamento * 100;
                    $custo_c = $value['custo_cubagem'] / $fat->Faturamento * 100;
                }
            }
            array_push($dataGraf['data_emis'], Carbon::create($value['data_emis'])->format('F Y'));
            array_push($dataGraf['custo_cubagem'], $custo_c);
            array_push($dataGraf['custo_peso'], $custo_p);
            array_push($dataGraf['meta'], $value['meta']);
        }
        return $dataGraf;
    }



    public function filtrar($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $this->dataGraf = DB::table('bexsal_reports.report_076', 'cb')
            ->select(
                DB::raw('DATE_FORMAT(IF((con.data_emissao IS NOT NULL), con.data_emissao, cb.data_baixa), "%Y-%m") AS data_emis'),
                DB::raw('SUM((cb.peso_calculo * (mv.valor_a_pagar / mv.peso_ctrcs_ctrb_coleta_entrega))) AS custo_peso'),
                DB::raw('SUM((con.cubagem_m3 * (mv.valor_a_pagar / bexsal_reports.cub.cubagem_total)))AS custo_cubagem'),
                'mt.META_COLETA as meta'
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'bexsal_reports.cub.ctrb')
            ->join('dim_meta as mt', function ($join){
                $join->on(DB::raw("IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa))"), '=', 'mt.ANO');
                $join->on(DB::raw("IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))"), '=', 'mt.MES');
            })
            ->where('cb.tipo_baixa', '=', 'C')
            ->when($filtros['ano'], function ($query) use($filtros){
                $query->whereYear('con.data_emissao', $filtros['ano']);
            })
            ->groupBy(DB::raw('IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa)), IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))'))
            ->get();


        $this->dispatchBrowserEvent(
            'renderDataCustMeta',
            [
                'newData' => $this->dataGraf
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-coletas.grafico-realizado-meta');
    }
}
