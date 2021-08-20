<?php

namespace App\Http\Livewire\Components\Menus;

use App\Models\DimMeta;
use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Filtros extends Component
{
    public $search, $isEmpty = '';

    public array $filtros = [
        'dataStart' => null,
        'dataEnd' => null,
        'ano' => null,
        'mes' => null,
        'trimestre' => null,
        'searchCliente' => null,
        'searchBase' => null,
        'orderDesvios' => null,
        'searchSegmentos' => null
    ];

    public function resetFilters()
    {
        $this->reset('filtros', 'search');
    }


    public function filtrar()
    {
        $this->emit('filtros', $this->filtros);
    }

    public function changeSearch($search)
    {
        $this->filtros['searchCliente'] = $search;
        $this->search = $search;
    }

    public function render()
    {
        $periodArray = [
            'year'  => [],
            'month' => []
        ];
        $period = DimMeta::select('ANO', 'MES')->get();
        foreach ($period as $p){
            if (!in_array($p->ANO, $periodArray['year'])) {
                array_push($periodArray['year'], $p->ANO);
            }
            $month = Carbon::create($p->ANO, $p->MES)->monthName;
            $periodArray['month'][$p->MES] = $month;
        }
        ;
        if (!empty($this->search)) {
            $articles = TabelaCtes::select(DB::raw('distinct(nome_pagador)'))
                ->where('nome_pagador', 'LIKE', '%' . $this->search . '%')
                ->get();
            $this->isEmpty = '';
        } else {
            $articles = [];
            $this->isEmpty = __('Nothings Found.');
        }

        $segmentos = DB::table('tabela_ctes')
            ->select('segmento')
            ->distinct()
            ->get();
        $listSegmentos = [];
        foreach($segmentos as $ls){
            array_push($listSegmentos, $ls->segmento);
        }

        $bases = DB::table('bexsal_bdsal.relacao_unidade_local','bas')
            ->select('bas.sigla')
            ->join('bexsal_bdsal.tabela_ctes as ct', function ($join) {
                $join->on('bas.sigla', '=', 'ct.und_emissora');
                $join->orOn('bas.sigla', '=', 'ct.und_receptora');
            })
            ->distinct()
            ->get();
        $listBases = [];
        foreach($bases as $ls){
            array_push($listBases, $ls->sigla);
        }
        return view('livewire.components.menus.filtros', [
            'segmentolist' => $listSegmentos,
            'listBases' => $listBases,
            'articles' => $articles,
            'period' => $periodArray
        ]);
    }
}
