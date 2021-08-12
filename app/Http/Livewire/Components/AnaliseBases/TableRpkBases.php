<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkBases extends Component
{
    public $tableRpkBases;
    public $year;
    public $month;
    public $maior = 0;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->tableRpkBases = TabelaCtes::select("und_receptora as Base",
            DB::raw('(SUM(val_frete) / COUNT(0)) AS TKM'),
            DB::raw("(SUM(val_frete) / SUM(peso_cal_kg)) AS RPK"),
            DB::raw("((100 * SUM(val_frete)) / SUM(val_mercadoria)) AS '% Frete/Valor Mercadoria'"),
            DB::raw("COUNT(0) AS 'Qtde CTRC'")
        )
            ->where('ano',Carbon::today()->year)
            ->where('mes',Carbon::today()->month)
            ->orderBy('Qtde CTRC', 'desc')
            ->groupBy('und_receptora')
            ->get()
            ->toArray();

        foreach ($this->tableRpkBases as $t){
            if($this->maior < $t["Qtde CTRC"]){
                $this->maior = $t["Qtde CTRC"];
            }
        }
    }

    public function filtrar($filtro)
    {
        $filtro['ano'] = $filtro['ano'] ?? Carbon::today()->year;
        $filtro['mes'] = $filtro['mes'] ?? Carbon::today()->month;
        $this->tableRpkBases = TabelaCtes::select("und_receptora as Base",
            DB::raw('(SUM(val_frete) / COUNT(0)) AS TKM'),
            DB::raw("(SUM(val_frete) / SUM(peso_cal_kg)) AS RPK"),
            DB::raw("((100 * SUM(val_frete)) / SUM(val_mercadoria)) AS '% Frete/Valor Mercadoria'"),
            DB::raw("COUNT(0) AS 'Qtde CTRC'")
        )
            ->Search($filtro)
            ->orderBy('Qtde CTRC', 'desc')
            ->groupBy('und_receptora')
            ->get()
            ->toArray();

    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-rpk-bases');
    }
}

