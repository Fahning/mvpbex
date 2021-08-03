<?php

namespace App\Http\Livewire\Components\Menus;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Filtros extends Component
{

    public $filtros = [
        'dataStart' => null,
        'dataEnd' => null,
        'ano' => null,
        'mes' => null,
        'trimestre' => null,
        'searchCliente' => null,
        'searchBase' => null,
        'searchSegmentos' => null
    ];

    public function filtrar()
    {
        $this->filtros['ano'] = $this->filtros['ano'] ?? Carbon::today()->year;
        $this->filtros['mes'] = $this->filtros['mes'] ?? Carbon::today()->month;
        $this->emit('filtros', $this->filtros);

    }


    public function render()
    {
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
            'listBases' => $listBases
        ]);
    }
}
