<?php

namespace App\Http\Livewire\Components\Operacional\AnaliseDeEntregas;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Cards extends Component
{
    public $filtros = [
        'dataStart' => null,
        'dataEnd' => null,
        'ano' => null,
        'mes' => null,
        'trimestre' => null
    ];

    protected $listeners = ['filtros' => 'filtrar'];

    public function filtrar($filtros)
    {
        $this->filtros = $filtros;
    }

    public function render()
    {
        return view('livewire.components.operacional.analise-de-entregas.cards',[
            'cards' =>DB::table('conhecimento_baixa', 'cb')
                ->leftJoin('movromaneio',function($join) {
                    $join->on(DB::raw("CONCAT(cb.unidade,cb.ctrb_os)"), 'movromaneio.ctrb');
                })
                ->leftJoin(DB::raw("(SELECT ctrc, SUM(cubagem) as cubagem_total FROM notas WHERE cubagem <> 0 GROUP BY ctrc) AS cub"),
                    'cb.ctrc', '=', 'cub.ctrc')
                ->leftJoin('tabela_ctes as nf', 'cb.ctrc', '=', 'nf.ctrc' )
                ->selectRaw("(SELECT SUM(faturamento) as faturamento FROM (SELECT con.data_emissao as emissao, SUM(DISTINCT rom.frete_ctrc) AS faturamento FROM romaneio as rom LEFT JOIN conhecimento as con ON rom.ctrc = con.ctrc GROUP BY rom.ctrc) as fat) AS Faturamento,
                                      SUM((movromaneio.valor_pagar/movromaneio.peso_ctrc)*(cb.pesocalc)) as 'Custo Peso Total',
                                      SUM((movromaneio.valor_pagar/cub.cubagem_total)*(nf.cubagem)) as 'Custo Cubagem Total'")
                ->when($this->filtros['dataStart'], function ($query) {
                    $query->where('nf.data_emissao', '>', $this->filtros['dataStart']);
                })
                ->when($this->filtros['dataEnd'], function ($query) {
                    $query->where('nf.data_emissao', '<', $this->filtros['dataEnd']);
                })
                ->when($this->filtros['ano'], function ($query) {
                    $query->where('nf.ano', '=', $this->filtros['ano']);
                })
                ->when($this->filtros['mes'], function ($query) {
                    $query->where('nf.mes', '=', $this->filtros['mes']);
                })
                ->when($this->filtros['trimestre'], function ($query) {
                    $query->where('nf.trimestre', '=', $this->filtros['trimestre']);
                })
                ->first(),
            'ctrb_os' => DB::table('conhecimento_baixa', 'cb')
                ->selectRaw('count(0) as total')
                ->leftJoin('conhecimento as con', 'cb.ctrc', '=', 'con.ctrc')
                ->whereNull('cb.ctrb_os')
                ->orWhere('cb.ctrb_os', '')
                ->first()
        ]);
    }
}
