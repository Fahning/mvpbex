<?php

namespace App\Http\Livewire\Components\Menus;

use App\Models\TabelaCtes;
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

        $bases = DB::table('tabela_ctes')
            ->select('und_emissora')
            ->distinct()
            ->get();
        $listBases = [];
        foreach($bases as $ls){
            array_push($listBases, $ls->und_emissora);
        }
        return view('livewire.components.menus.filtros', [
            'segmentolist' => $listSegmentos,
            'listBases' => $listBases,
            'articles' => $articles,
        ]);
    }
}
