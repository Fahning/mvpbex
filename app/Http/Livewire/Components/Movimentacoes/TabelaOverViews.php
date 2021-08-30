<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use App\Models\TabelaCtes;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class TabelaOverViews extends LivewireDatatable
{
    public $filtros;

    protected $listeners = ['filtroMovimentacoes'];


    public function filtroMovimentacoes($filtros)
    {
        $this->filtros = $filtros;
    }
    public function builder()
    {
        return TabelaCtes::query()
            ->leftJoin('bexsal_bdsal.calendar_dias_uteis as cl', function ($join){
                $join->on('tabela_ctes.ano', '=', 'cl.ano');
                $join->on('tabela_ctes.mes', '=', 'cl.mes');
            })
            ->leftJoin('bexsal_bdsal.relacao_unidade_local as rcl', 'rcl.sigla', '=', 'tabela_ctes.und_emissora')
            ->when($this->filtros, function ($query){
                if($this->filtros[0]){
                    $query->where('rcl.cidade', $this->filtros[0]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[1]){
                    $query->whereIn('tabela_ctes.und_emissora', $this->filtros[1]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[2]){
                    $query->where('tabela_ctes.nome_pagador', $this->filtros[2]);
                }
            })
            ->groupBy('tabela_ctes.ano', 'tabela_ctes.mes');
    }

    public function columns()
    {
        return [
            Column::name('ano'),
            Column::name('cl.mesnome')
            ->label('Mês'),
            Column::raw('SUM(tabela_ctes.val_frete) AS Receita', function ($value) {
                return formatReceita($value);
            }),
            Column::raw("(CASE
                            WHEN
                                ((tabela_ctes.mes = MONTH(CURDATE()))
                                    AND (tabela_ctes.ano = YEAR(CURDATE())))
                            THEN
                                (SUM(tabela_ctes.val_frete) / cl.dias_uteis_hoje)
                            ELSE (SUM(tabela_ctes.val_frete) / cl.dias_uteis)
                        END) AS Frete/Dia", function ($value) {
                return formatReceita($value);
            }),
            Column::raw('SUM(tabela_ctes.qtd_volumes) AS Volumes', function ($value) {
                return number_format($value,0,null, '.');
            }),
            Column::raw('SUM(tabela_ctes.cubagem) AS Cubagem', function ($value) {
                return formatM3($value);
            }),
            Column::raw('SUM(tabela_ctes.peso_real_kg) AS Peso', function ($value) {
                return formatPeso($value);
            }),
            Column::raw("SUM(tabela_ctes.val_mercadoria) AS Valor Mercadoria", function ($value) {
                return formatReceita($value);
            }),
            Column::raw("(CASE
                            WHEN
                                ((tabela_ctes.mes = MONTH(CURDATE()))
                                    AND (tabela_ctes.ano = YEAR(CURDATE())))
                            THEN
                                (SUM(tabela_ctes.val_mercadoria) / cl.dias_uteis_hoje)
                            ELSE (SUM(tabela_ctes.val_mercadoria) / cl.dias_uteis)
                        END) AS Valor Merc/Dia", function ($value) {
                return formatReceita($value);
            }),
        ];
    }
}
