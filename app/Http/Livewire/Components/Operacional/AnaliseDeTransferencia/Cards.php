<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeTransferencia;

use App\Models\DimMeta;
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
        $this->cards = DB::table('bexsal_reports.base_custos_transf', 'cc')
            ->select(
                DB::raw('SUM(cc.val_frete) as Faturamento'),
                DB::raw('SUM(cc.qtd_volumes) AS Volumes'),
                DB::raw('SUM(cc.custo_peso) AS "Custo Peso"'),
                DB::raw('SUM(cc.custo_cubagem) AS "Custo Cubagem"'),
                DB::raw('COUNT(0) AS "Qtde Transferencia"'),
                DB::raw('(SUM(cc.custo_peso) / SUM(cc.val_frete)) * 100 as "% Custo/Fat. (Peso)"'),
                DB::raw('(SUM(cc.custo_cubagem) / SUM(cc.val_frete)) * 100 as "% Custo/Fat. (Cubagem)"'),
                DB::raw('(SUM(cc.val_frete)) - SUM(cc.custo_peso) as "Margem Op./Kg"'),
                DB::raw('(SUM(cc.val_frete)) - SUM(cc.custo_cubagem) as "Margem Op./m³"'),
                DB::raw('COUNT(*) - COUNT(num_os) as "Coletas Com OS"'),
                DB::raw('COUNT(num_os) as "Coletas Sem OS"'),
            )
            ->whereYear('cc.emissao_manif', Carbon::today()->year)
            ->whereMonth('cc.emissao_manif', Carbon::today()->month)
            ->first();

        $this->cards = (array)$this->cards;

        $this->cards['Meta de Custo'] = DimMeta::select('META_TRANSFERENCIA')
            ->where('ANO', Carbon::today()->year)
            ->where('MES', Carbon::today()->month)
            ->first()->META_COLETA;
    }

    public function filtros($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;

        $this->cards['Meta de Custo'] = DimMeta::select('META_COLETA')
            ->where('ANO', $filtros['ano'])
            ->where('MES', $filtros['mes'])
            ->first()->META_COLETA;

        $this->cards = DB::table('bexsal_reports.base_custos_transf', 'cc')
            ->select(
                DB::raw('SUM(cc.val_frete) as Faturamento'),
                DB::raw('SUM(cc.custo_peso) AS "Custo Peso"'),
                DB::raw('SUM(cc.custo_cubagem) AS "Custo Cubagem"'),
                DB::raw('SUM(cc.qtd_volumes) AS Volumes'),
                DB::raw('COUNT(0) AS "Qtde Transferencia"'),
                DB::raw('(SUM(cc.custo_peso) / SUM(cc.val_frete)) * 100 as "% Custo/Fat. (Peso)"'),
                DB::raw('(SUM(cc.custo_cubagem) / SUM(cc.val_frete)) * 100 as "% Custo/Fat. (Cubagem)"'),
                DB::raw('(SUM(cc.val_frete)) - SUM(cc.custo_peso) as "Margem Op./Kg"'),
                DB::raw('(SUM(cc.val_frete)) - SUM(cc.custo_cubagem) as "Margem Op./m³"'),
                DB::raw('COUNT(*) - COUNT(num_os) as "Coletas Com OS"'),
                DB::raw('COUNT(num_os) as "Coletas Sem OS"'),
            )
            ->whereYear('cc.emissao_manif', $filtros['ano'])
            ->whereMonth('cc.emissao_manif', $filtros['mes'])
            ->when($filtros['searchCliente'], function ($query) use($filtros){
                $query->where('cc.nome_pagador', $filtros['searchCliente']);
            })
            ->when($filtros['searchBase'], function ($query) use($filtros){
                $query->where('cc.und_origem', $filtros['searchBase']);
            })
            ->when($filtros['searchSegmentos'], function ($query) use($filtros){
                $query->where('cc.segmento', $filtros['searchSegmentos']);
            })
            ->first();

        if(empty($this->cards)){
            $this->dialog()->error(
                $title = 'Alguns dados não serão exibidos!',
                $description = 'Isso ocorre por falta de dados para o filtro selecionado.'
            );
            $this->cards = [
                'Faturamento' => 0,
                'Custo Peso' => 0,
                'Custo Cubagem' => 0,
                'Total de Volumes' => 0,
                'Coletas Com OS' => 0,
                'Coletas Sem OS' => 0,
                '% Custo/Fat. (Peso)' => 0,
                '% Custo/Fat. (Cubagem)' => 0,
            ];
        }else {
            $this->cards = (array)$this->cards;
        }
    }
    public function render()
    {
        return view('livewire.components.operacional.analise-de-transferencia.cards');
    }
}
