<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeColetas;

use App\Models\DimMeta;
use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cards extends Component
{
    public $cards= [];

    protected $listeners = ['filtros'];


    public function mount()
    {
        $this->cards['Faturamento'] = TabelaCtes::select(DB::raw('SUM(val_frete) as Faturamento'))
            ->where('ano', Carbon::today()->year)
            ->where('mes', Carbon::today()->month)
            ->where('placa_coleta', '<>', 'ARMAZEM')
            ->whereIn('tipo_doc',['NORMAL','SUBC FORM CTRC'])
            ->first()->Faturamento;

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
            ->where('cb.tipo_baixa', '=', 'C')
            ->where(function($query){
                $query->whereYear('con.data_emissao', Carbon::today()->year)
                    ->whereMonth('con.data_emissao', Carbon::today()->month);
            })
            ->orWhere(function($query){
                $query->whereYear('cb.data_baixa', Carbon::today()->year)
                    ->whereMonth('cb.data_baixa', Carbon::today()->month);
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

        $this->cards['Custo Extra'] = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw('SUM(mv.valor_a_pagar) AS CustoExtra'))
            ->rightJoin('bexsal_reports.report_073 as mv', 'cb.ctrb_os', '=', 'mv.ctrb')
            ->whereNull('cb.ctrb_os')
            ->where('mv.tipo', 'COLETA/ENTREGA')
            ->whereYear('mv.emissao', Carbon::today()->year)
            ->whereMonth('mv.emissao', Carbon::today()->month)
            ->first()->CustoExtra;


        $coletas = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw('
            COUNT(*) - COUNT(cb.ctrb_os) as Nulos,
            COUNT(cb.ctrb_os) as Validos'
            ))
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->where(function($query){
                $query->whereYear('con.data_emissao', Carbon::today()->year)
                    ->whereMonth('con.data_emissao', Carbon::today()->month);
            })
            ->orWhere(function($query){
                $query->whereYear('cb.data_baixa', Carbon::today()->year)
                    ->whereMonth('cb.data_baixa', Carbon::today()->month);
            })
            ->where('cb.tipo_baixa', 'C')
            ->first();
        $this->cards['Coletas Com OS'] = $coletas->Validos;
        $this->cards['Coletas Sem OS'] = $coletas->Nulos;

        $this->cards['% Custo/Fat. (Peso)'] = floatval($this->cards['Custo Peso']) / floatval($this->cards['Faturamento']) * 100;
        $this->cards['% Custo/Fat. (Cubagem)'] = floatval($this->cards['Custo Cubagem']) / floatval($this->cards['Faturamento']) * 100;
        $this->cards['Meta de Custo'] = DimMeta::select('META_COLETA')
        ->where('ANO', Carbon::today()->year)
        ->where('MES', Carbon::today()->month)
        ->first()->META_COLETA;

    }

    public function filtros($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $this->cards['Faturamento'] = TabelaCtes::select(DB::raw('SUM(val_frete) as Faturamento'))
            ->where('ano', $filtros['ano'])
            ->where('mes', $filtros['mes'])
            ->where('placa_coleta', '<>', 'ARMAZEM')
            ->whereIn('tipo_doc',['NORMAL','SUBC FORM CTRC'])
            ->first()->Faturamento;

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
            ->where('cb.tipo_baixa', '=', 'C')
            ->where(function($query) use($filtros) {
                $query->whereYear('con.data_emissao', $filtros['ano'])
                    ->whereMonth('con.data_emissao', $filtros['mes']);
            })
            ->orWhere(function($query) use($filtros){
                $query->whereYear('cb.data_baixa', $filtros['ano'])
                    ->whereMonth('cb.data_baixa', $filtros['mes']);
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

        $this->cards['Custo Extra'] = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw('SUM(mv.valor_a_pagar) AS CustoExtra'))
            ->rightJoin('bexsal_reports.report_073 as mv', 'cb.ctrb_os', '=', 'mv.ctrb')
            ->whereNull('cb.ctrb_os')
            ->where('mv.tipo', 'COLETA/ENTREGA')
            ->whereYear('mv.emissao', $filtros['ano'])
            ->whereMonth('mv.emissao', $filtros['mes'])
            ->first()->CustoExtra;


        $coletas = DB::table('bexsal_reports.report_076', 'cb')
            ->select(DB::raw('
            COUNT(*) - COUNT(cb.ctrb_os) as Nulos,
            COUNT(cb.ctrb_os) as Validos'
            ))
            ->leftJoin('bexsal_reports.report_455 as con', DB::raw("REPLACE(cb.ctrc, '/', '')"), '=', 'con.numero_ctrc')
            ->where(function($query) use($filtros){
                $query->whereYear('con.data_emissao', $filtros['ano'])
                    ->whereMonth('con.data_emissao', $filtros['mes']);
            })
            ->orWhere(function($query) use($filtros){
                $query->whereYear('cb.data_baixa', $filtros['ano'])
                    ->whereMonth('cb.data_baixa', $filtros['mes']);
            })
            ->where('cb.tipo_baixa', 'C')
            ->first();
        $this->cards['Coletas Com OS'] = $coletas->Validos;
        $this->cards['Coletas Sem OS'] = $coletas->Nulos;

        $this->cards['% Custo/Fat. (Peso)'] = floatval($this->cards['Custo Peso']) / floatval($this->cards['Faturamento']) * 100;
        $this->cards['% Custo/Fat. (Cubagem)'] = floatval($this->cards['Custo Cubagem']) / floatval($this->cards['Faturamento']) * 100;
        $this->cards['Meta de Custo'] = DimMeta::select('META_COLETA')
            ->where('ANO', $filtros['ano'])
            ->where('MES', $filtros['mes'])
            ->first()->META_COLETA;

    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-coletas.cards');
    }
}
