<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeColetas;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoCustos extends Component
{
    public $dataGraf;

    protected $listeners = ['filtros' => 'filtrar'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataCustColeta',
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
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'bexsal_reports.cub.ctrb')
            ->where('cb.tipo_baixa', '=', 'C')
            ->orderBy('data_emis', 'asc')
            ->groupBy(DB::raw('IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa)), IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))'))
            ->get();

    }

    public function formatData($data)
    {
        $dataGraf = [
            'data_emis' => [],
            'custo_cubagem' => [],
            'custo_peso' => []
        ];
        foreach ($data as $value){
            $value = collect($value);
            array_push($dataGraf['data_emis'], Carbon::create($value['data_emis'] )->format('F Y'));
            array_push($dataGraf['custo_cubagem'], $value['custo_cubagem']);
            array_push($dataGraf['custo_peso'], $value['custo_peso']);
        }
        return $dataGraf;
    }



    public function filtrar($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $this->dataGraf = DB::table('bexsal_reports.report_076', 'cb')
            ->select(
                DB::raw('DATE_FORMAT(IF((con.data_emissao IS NOT NULL), con.data_emissao, cb.data_baixa), "%Y-%m") AS data_emis'),
                DB::raw('SUM((cb.peso_calculo * (mv.valor_a_pagar / mv.peso_ctrcs_ctrb_coleta_entrega))) AS custo_peso'),
                DB::raw('SUM((con.cubagem_m3 * (mv.valor_a_pagar / bexsal_reports.cub.cubagem_total)))AS custo_cubagem'),
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'bexsal_reports.cub.ctrb')
            ->where('cb.tipo_baixa', '=', 'C')
            ->when($filtros['ano'], function ($query) use($filtros){
                $query->whereYear('con.data_emissao', $filtros['ano']);
            })
            ->when($filtros['searchCliente'], function ($query) use($filtros){
                $query->where('con.cliente_pagador', $filtros['searchCliente']);
            })
            ->when($filtros['searchBase'], function ($query) use($filtros){
                $query->whereIn('cb.unidade', $filtros['searchBase']);
            })
            ->when($filtros['searchSegmentos'], function ($query) use($filtros){
                $query->whereIn(DB::raw("IF(con.segmento_pagador IS NOT NULL, con.segmento_pagador, 'OUTROS')"), $filtros['searchSegmentos']);
            })
            ->orderBy('data_emis', 'asc')
            ->groupBy(DB::raw('IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa)), IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))'))
            ->get();
        $this->dispatchBrowserEvent(
            'renderDataCustColeta',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-coletas.grafico-custos');
    }
}
