<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeColetas;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GraficoColetaSegmento extends Component
{
    public $dataGraf;

    protected $listeners = ['filtros' => 'filtrar'];

    public function montaChart()
    {
        $this->dispatchBrowserEvent(
            'renderDataColetaSegmento',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }

    public function mount()
    {
        $this->dataGraf = DB::table('bexsal_reports.report_076', 'cb')
            ->select(
                DB::raw("IF(con.segmento_pagador IS NOT NULL, con.segmento_pagador, 'OUTROS') AS segmento"),
                DB::raw('sum(cb.peso_calculo * (mv.valor_a_pagar / mv.peso_ctrcs_ctrb_coleta_entrega)) AS custo_peso'),
                DB::raw('SUM((con.cubagem_m3 * (mv.valor_a_pagar / bexsal_reports.cub.cubagem_total)))AS custo_cubagem')
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'bexsal_reports.cub.ctrb')
            ->where('cb.tipo_baixa', '=', 'C')
             ->where(DB::raw("IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))"), Carbon::today()->month)
            ->where(DB::raw("IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa))"), Carbon::today()->year)
            ->groupBy('con.segmento_pagador')
            ->get();
    }

    public function formatData($data)
    {
        $dataGraf = [
            'segmento' => [],
            'custo_cubagem' => [],
            'custo_peso' => []
        ];
        foreach ($data as $value){
            $value = (array)$value;
            array_push($dataGraf['segmento'], $value['segmento']);
            array_push($dataGraf['custo_cubagem'], $value['custo_cubagem']);
            array_push($dataGraf['custo_peso'], $value['custo_peso']);
        }
        return $dataGraf;
    }



    public function filtrar($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $this->dataGraf = DB::table('bexsal_reports.report_076', 'cb')
            ->select(
                DB::raw("IF(con.segmento_pagador IS NOT NULL, con.segmento_pagador, 'OUTROS') AS segmento"),
                DB::raw('sum(cb.peso_calculo * (mv.valor_a_pagar / mv.peso_ctrcs_ctrb_coleta_entrega)) AS custo_peso'),
                DB::raw('SUM((con.cubagem_m3 * (mv.valor_a_pagar / bexsal_reports.cub.cubagem_total)))AS custo_cubagem')
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'bexsal_reports.cub.ctrb')
            ->where('cb.tipo_baixa', '=', 'C')
            ->when($filtros['ano'], function ($query) use($filtros){
                    $query->where(DB::raw("IF((con.data_emissao IS NOT NULL), YEAR(con.data_emissao), YEAR(cb.data_baixa))"), $filtros['ano']);
            })
            ->when($filtros['mes'], function ($query) use($filtros){
                $query->where(DB::raw("IF((con.data_emissao IS NOT NULL), MONTH(con.data_emissao), MONTH(cb.data_baixa))"), $filtros['mes']);
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
            ->groupBy('con.segmento_pagador')
            ->get();

        $this->dispatchBrowserEvent(
            'renderDataColetaSegmento',
            [
                'newData' => $this->formatData($this->dataGraf)
            ]
        );
    }
    public function render()
    {
        return view('livewire.components.operacional.analise-de-coletas.grafico-coleta-segmento');
    }
}
