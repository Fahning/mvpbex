<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeEntregas;

use App\Models\DimMeta;
use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class Cards extends Component
{
    use Actions;
    public $cards= [];

    protected $listeners = ['filtros'];

    public function mount()
    {
        $fats = DB::table('bexsal_reports.report_036', 'romaneio')
            ->selectRaw('SUM(DISTINCT romaneio.frete_ctrc) AS faturamento')
            ->leftJoin('bexsal_reports.report_455 as con', 'romaneio.ctrc', '=', 'con.numero_ctrc')
            ->where(function($query){
                $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(romaneio.data_emissao))'), Carbon::today()->year)
                    ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(romaneio.data_emissao))'), Carbon::today()->month);
            })
            ->groupBy('romaneio.ctrc')
            ->get();

        $this->cards['Faturamento'] = 0;
        foreach ($fats as $fat) {
            $this->cards['Faturamento'] += $fat->faturamento;
        }

         $data = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw("DISTINCT
                                cb.ctrc,
                                mv.ctrb,
                                cb.qtvol as volumes"
            ),
                DB::raw('cb.peso_calculo*(mv.valor_a_pagar/mv.peso_ctrcs_ctrb_coleta_entrega) as custo_peso'),
                DB::raw('(con.cubagem_m3 * (mv.valor_a_pagar / cub.cubagem_total)) AS custo_cubagem')
            )
            ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
            ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'cub.ctrb')
             ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->where('cb.tipo_baixa', '=', 'E')
            ->where(function($query){
                $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(cb.data_baixa))'), Carbon::today()->year)
                    ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(cb.data_baixa))'), Carbon::today()->month);
            })
            ->get();
        $this->cards['Custo Peso'] = 0;
        $this->cards['Custo Cubagem'] = 0;
        $this->cards['Total de Volumes'] = 0;
        foreach ($data as $d){
            $this->cards['Custo Peso'] += $d->custo_peso;
            $this->cards['Custo Cubagem'] += $d->custo_cubagem;
            $this->cards['Total de Volumes'] += $d->volumes;
        }

        $bases = DB::table('bexsal_reports.report_076', 'cb')
            ->selectRaw('DISTINCT(cb.unidade)')
            ->where('cb.tipo_baixa', '=', 'E')
            ->get()->toArray();
        $basesArray = [];
        foreach ($bases as $b){
            array_push($basesArray, $b->unidade);
        }

        $this->cards['Custo Extra'] = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw('SUM(mv.valor_a_pagar) AS CustoExtra'))
            ->rightJoin('bexsal_reports.report_073 as mv', 'cb.ctrb_os', '=', 'mv.ctrb')
            ->whereNull('cb.ctrb_os')
            ->where('mv.tipo', 'COLETA/ENTREGA')
            ->whereIn(DB::raw('SUBSTRING(mv.ctrb, 1, 3)'), $basesArray)
            ->whereYear('mv.emissao', Carbon::today()->year)
            ->whereMonth('mv.emissao', Carbon::today()->month)
            ->first()->CustoExtra;

        $this->cards['Margem Op./Kg'] = $this->cards['Faturamento'] - ($this->cards['Custo Peso'] + $this->cards['Custo Extra']);
        $this->cards['Margem Op./m³'] = $this->cards['Faturamento'] - ($this->cards['Custo Cubagem'] + $this->cards['Custo Extra']);;


        $coletas = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw('
            COUNT(*) - COUNT(cb.ctrb_os) as Nulos,
            COUNT(cb.ctrb_os) as Validos'
            ))
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->where(function($query){
                $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(cb.data_baixa))'), Carbon::today()->year)
                    ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(cb.data_baixa))'), Carbon::today()->month);
            })
            ->where('cb.tipo_baixa', 'E')
            ->first();

        $this->cards['% Custo/Fat. (Peso)'] = floatval($this->cards['Custo Peso']) / floatval($this->cards['Faturamento']) * 100;
        $this->cards['% Custo/Fat. (Cubagem)'] = floatval($this->cards['Custo Cubagem']) / floatval($this->cards['Faturamento']) * 100;
        $this->cards['Meta de Custo'] = DimMeta::select('META_ENTREGA')
        ->where('ANO', Carbon::today()->year)
        ->where('MES', Carbon::today()->month)
        ->first()->META_COLETA;

        $this->cards['Coletas Com OS'] = $coletas->Validos;
        $this->cards['Coletas Sem OS'] = $coletas->Nulos;
    }

    public function filtros($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $fats = DB::table('bexsal_reports.report_036', 'romaneio')
            ->selectRaw('SUM(DISTINCT romaneio.frete_ctrc) AS faturamento')
            ->leftJoin('bexsal_reports.report_455 as con', 'romaneio.ctrc', '=', 'con.numero_ctrc')
            ->where(function($query) use($filtros){
                $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(romaneio.data_emissao))'), $filtros['ano'])
                    ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(romaneio.data_emissao))'), $filtros['mes']);
            })
            ->when($filtros['searchCliente'], function ($query) use($filtros){
                $query->where('con.cliente_pagador', $filtros['searchCliente']);
            })
            ->when($filtros['searchSegmentos'], function($query) use($filtros) {
                $query->whereIn(DB::raw('IF(con.segmento_pagador IS NOT NULL, con.segmento_pagador, "OUTROS")'), $filtros['searchSegmentos']);
            })
            ->when($filtros['searchBase'], function($query) use($filtros) {
                $query->whereIn('con.unidade_receptora', $filtros['searchBase']);
            })
            ->groupBy('romaneio.ctrc')
            ->get();

        $this->cards['Faturamento'] = 0;
        foreach ($fats as $fat) {
            $this->cards['Faturamento'] += $fat->faturamento;
        }

        if($this->cards['Faturamento'] == 0){
            $this->dialog()->error(
                $title = 'Alguns dados não serão exibidos!',
                $description = 'Isso ocorre por falta de dados para o filtro selecionado.'
            );

            $this->cards = [
                'Faturamento' => 0,
                'Custo Peso' => 0,
                'Custo Cubagem' => 0,
                'Total de Volumes' => 0,
                'Custo Extra' => 0,
                'Coletas Com OS' => 0,
                'Coletas Sem OS' => 0,
                '% Custo/Fat. (Peso)' => 0,
                '% Custo/Fat. (Cubagem)' => 0,
                'Meta de Custo' => 0,
            ];
        }else {
            $data = DB::table('bexsal_reports.report_076', 'cb')
                ->select(DB::raw("DISTINCT
                                    cb.ctrc,
                                    mv.ctrb,
                                    cb.qtvol as volumes"
                ),
                    DB::raw('cb.peso_calculo*(mv.valor_a_pagar/mv.peso_ctrcs_ctrb_coleta_entrega) as custo_peso'),
                    DB::raw('(con.cubagem_m3 * (mv.valor_a_pagar / cub.cubagem_total)) AS custo_cubagem')
                )
                ->join('bexsal_reports.report_073 as mv', DB::raw('CONCAT(cb.unidade, cb.ctrb_os)'), '=', 'mv.ctrb')
                ->join('bexsal_reports.cubagem_total_ctrb as cub', 'mv.ctrb', '=', 'cub.ctrb')
                ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
                ->where('cb.tipo_baixa', '=', 'E')
                ->where(function($query) use($filtros){
                    $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(cb.data_baixa))'), $filtros['ano'])
                        ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(cb.data_baixa))'), $filtros['mes']);
                })
                ->when($filtros['searchCliente'], function ($query) use($filtros){
                    $query->where('con.cliente_pagador', $filtros['searchCliente']);
                })
                ->when($filtros['searchSegmentos'], function($query) use($filtros) {
                    $query->whereIn(DB::raw('IF(con.segmento_pagador IS NOT NULL, con.segmento_pagador, "OUTROS")'), $filtros['searchSegmentos']);
                })
                ->when($filtros['searchBase'], function($query) use($filtros) {
                    $query->whereIn('cb.unidade', $filtros['searchBase']);
                })
            ->where(function($query) use($filtros){
                $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(cb.data_baixa))'), $filtros['ano'])
                    ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(cb.data_baixa))'), $filtros['mes']);
            })
                ->get();
            $this->cards['Custo Peso'] = 0;
            $this->cards['Custo Cubagem'] = 0;
            $this->cards['Total de Volumes'] = 0;
            foreach ($data as $d) {
                $this->cards['Custo Peso'] += $d->custo_peso;
                $this->cards['Custo Cubagem'] += $d->custo_cubagem;
                $this->cards['Total de Volumes'] += $d->volumes;
            }

            $bases = DB::table('bexsal_reports.report_076', 'cb')
                ->selectRaw('DISTINCT(cb.unidade)')
                ->where('cb.tipo_baixa', '=', 'E')
                ->when($filtros['searchBase'], function ($query) use($filtros){
                    $query->whereIn('cb.unidade', $filtros['searchBase']);
                })
                ->get()->toArray();
            $basesArray = [];
            foreach ($bases as $b){
                array_push($basesArray, $b->unidade);
            }

            if(is_null($filtros['searchCliente']) && is_null($filtros['searchSegmentos'])){
                $this->cards['Custo Extra'] = DB::table('bexsal_reports.report_076', 'cb')
                    ->select(DB::raw('SUM(mv.valor_a_pagar) AS CustoExtra'))
                    ->rightJoin('bexsal_reports.report_073 as mv', 'cb.ctrb_os', '=', 'mv.ctrb')
                    ->whereNull('cb.ctrb_os')
                    ->where('mv.tipo', 'COLETA/ENTREGA')
                    ->whereIn(DB::raw('SUBSTRING(mv.ctrb, 1, 3)'), $basesArray)
                    ->whereYear('mv.emissao', $filtros['ano'])
                    ->whereMonth('mv.emissao', $filtros['mes'])
                    ->first()->CustoExtra;
            }else{
                $this->cards['Custo Extra'] = 0;
            }

            $this->cards['Margem Op./Kg'] = $this->cards['Faturamento'] - ($this->cards['Custo Peso'] + $this->cards['Custo Extra']);
            $this->cards['Margem Op./m³'] = $this->cards['Faturamento'] - ($this->cards['Custo Cubagem'] + $this->cards['Custo Extra']);;

            $coletas = DB::table('bexsal_reports.report_076', 'cb')
                ->select(DB::raw('
                COUNT(*) - COUNT(cb.ctrb_os) as Nulos,
                COUNT(cb.ctrb_os) as Validos'
                ))
                ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
                ->where(function($query) use($filtros){
                    $query->where(DB::raw('IF(con.data_emissao IS NOT NULL, year(con.data_emissao), year(cb.data_baixa))'), $filtros['ano'])
                        ->where(DB::raw('IF(con.data_emissao IS NOT NULL, month(con.data_emissao), month(cb.data_baixa))'), $filtros['mes']);
                })
                ->when($filtros['searchCliente'], function ($query) use($filtros){
                    $query->where('con.cliente_pagador', $filtros['searchCliente']);
                })
                ->when($filtros['searchSegmentos'], function($query) use($filtros) {
                    $query->whereIn(DB::raw('IF(con.segmento_pagador IS NOT NULL, con.segmento_pagador, "OUTROS")'), $filtros['searchSegmentos']);
                })
                ->when($filtros['searchBase'], function($query) use($filtros) {
                    $query->whereIn('cb.unidade', $filtros['searchBase']);
                })
                ->where('cb.tipo_baixa', 'E')
                ->first();


            $this->cards['% Custo/Fat. (Peso)'] = floatval($this->cards['Custo Peso']) / floatval($this->cards['Faturamento']) * 100;
            $this->cards['% Custo/Fat. (Cubagem)'] = floatval($this->cards['Custo Cubagem']) / floatval($this->cards['Faturamento']) * 100;

            $this->cards['Meta de Custo'] = DimMeta::select('META_COLETA')
                ->where('ANO', $filtros['ano'])
                ->where('MES', $filtros['mes'])
                ->first()->META_COLETA;
            $this->cards['Coletas Com OS'] = $coletas->Validos;
            $this->cards['Coletas Sem OS'] = $coletas->Nulos;
        }

    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-entregas.cards');
    }
}
