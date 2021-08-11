<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use App\Models\TabelaCtes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TabelaDistribuicao extends Component
{
    public $tableDistribuicao;
    public $year;
    public $month;
    public $maior = 0;
    public $persp = 'Peso';
    public $filtros2 = [
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

    private $perspectiva = [
        'Volumes' => "CASE WHEN ((peso_real_kg / qtd_volumes) <= '10') THEN '0 a 10 kg' WHEN     (((peso_real_kg / qtd_volumes) > '10')         AND ((peso_real_kg / qtd_volumes) <= '20')) THEN     '10 a 20 kg' WHEN     (((peso_real_kg / qtd_volumes) > '20')         AND ((peso_real_kg / qtd_volumes) <= '40')) THEN     '20 a 40 kg' WHEN     (((peso_real_kg / qtd_volumes) > '40')         AND ((peso_real_kg / qtd_volumes) <= '80')) THEN     '40 a 80 kg' WHEN     (((peso_real_kg / qtd_volumes) > '80')         AND ((peso_real_kg / qtd_volumes) <= '100')) THEN     '80 a 100 kg' WHEN     (((peso_real_kg / qtd_volumes) > '100')         AND ((peso_real_kg / qtd_volumes) <= '200')) THEN     '100 a 200 kg' ELSE 'Acima de 200 kg' END AS Intervalo",
        'Peso' => "CASE WHEN ((peso_real_kg) <= '10') THEN '0 a 10 kg' WHEN     (((peso_real_kg) > '10')         AND ((peso_real_kg) <= '20')) THEN     '10 a 20 kg' WHEN     (((peso_real_kg) > '20')         AND ((peso_real_kg) <= '40')) THEN     '20 a 40 kg' WHEN     (((peso_real_kg) > '40')         AND ((peso_real_kg) <= '80')) THEN     '40 a 80 kg' WHEN     (((peso_real_kg) > '80')         AND ((peso_real_kg) <= '100')) THEN     '80 a 100 kg' WHEN     (((peso_real_kg) > '100')         AND ((peso_real_kg) <= '200')) THEN     '100 a 200 kg' ELSE 'Acima de 200 kg' END AS Intervalo",
        'Cubagem' => "CASE WHEN (cubagem <= '10') THEN '0 a 10 m3' WHEN     ((cubagem > '10')         AND (cubagem <= '20')) THEN     '10 a 20 m3' WHEN     ((cubagem > '20')         AND (cubagem <= '40')) THEN     '20 a 40 m3' WHEN     ((cubagem > '40')         AND (cubagem <= '80')) THEN     '40 a 80 m3' WHEN     ((cubagem > '80')         AND (cubagem <= '100')) THEN     '80 a 100 m3' WHEN     ((cubagem > '100')         AND (cubagem <= '200')) THEN     '100 a 200 m3' ELSE 'Acima de 200 m3' END AS Intervalo"
       ];
    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->tableDistribuicao = TabelaCtes::select(DB::raw($this->perspectiva[$this->persp]),
            DB::raw("COUNT(ctrc) AS 'Qtde de CTRC'"),
            DB::raw("SUM(val_frete) AS Receita")
        )
            ->where('ano', Carbon::today()->year)
            ->where('mes', Carbon::today()->month)
            ->orderBy('Qtde de CTRC', 'desc')
            ->groupBy('Intervalo', 'ano', 'mes')
            ->get();

        $tabela_auxiliar = TabelaCtes::select(
            'ano',
            'mes',
            DB::raw('COUNT(0) AS total'),
            DB::raw('SUM(val_frete) AS receita')
        )
            ->where('ano', Carbon::today()->year)
            ->where('mes', Carbon::today()->month)
            ->groupBy('ano', 'mes')
            ->get();

        foreach ($this->tableDistribuicao as $key => $td){
            $this->tableDistribuicao[$key]['% Total Qtde'] = $td->{'Qtde de CTRC'} * 100 / $tabela_auxiliar[0]->total;
            $this->tableDistribuicao[$key]['% Total Receita'] = $td->Receita * 100 / $tabela_auxiliar[0]->receita;
            if($this->maior < $td->{"Qtde de CTRC"}){
                $this->maior = $td->{"Qtde de CTRC"};
            }
        }

        $this->tableDistribuicao = $this->tableDistribuicao->toArray();

    }

    public function filtrar($filtros)
    {
        $filtros['ano'] = $filtros['ano'] ?? Carbon::today()->year;
        $filtros['mes'] = $filtros['mes'] ?? Carbon::today()->month;
        $this->filtros2 = $filtros;
        $this->tableDistribuicao = TabelaCtes::select(DB::raw($this->perspectiva[$this->persp]),
            DB::raw("COUNT(ctrc) AS 'Qtde de CTRC'"),
            DB::raw("SUM(val_frete) AS Receita")
        )
            ->Search($this->filtros2)
            ->orderBy('Qtde de CTRC', 'desc')
            ->groupBy('Intervalo', 'ano', 'mes')
            ->get();

        $tabela_auxiliar = TabelaCtes::select(
            'ano',
            'mes',
            DB::raw('COUNT(0) AS total'),
            DB::raw('SUM(val_frete) AS receita')
        )
            ->Search($this->filtros2)
            ->groupBy('ano', 'mes')
            ->get();

        foreach ($this->tableDistribuicao as $key => $td){
            $this->tableDistribuicao[$key]['% Total Qtde'] = $td->{'Qtde de CTRC'} * 100 / $tabela_auxiliar[0]->total;
            $this->tableDistribuicao[$key]['% Total Receita'] = $td->Receita * 100 / $tabela_auxiliar[0]->receita;
        }

        $this->tableDistribuicao = $this->tableDistribuicao->toArray();
    }

    public function perspectiva()
    {
        $this->filtros2['ano'] = $this->filtros2['ano'] ?? Carbon::today()->year;
        $this->filtros2['mes'] = $this->filtros2['mes'] ?? Carbon::today()->month;
        $this->tableDistribuicao = TabelaCtes::select(DB::raw($this->perspectiva[$this->persp]),
            DB::raw("COUNT(ctrc) AS 'Qtde de CTRC'"),
            DB::raw("SUM(val_frete) AS Receita")
        )
            ->Search($this->filtros2)
            ->orderBy('Qtde de CTRC', 'desc')
            ->groupBy('Intervalo', 'ano', 'mes')
            ->get();


        $tabela_auxiliar = TabelaCtes::select(
            'ano',
            'mes',
            DB::raw('COUNT(0) AS total'),
            DB::raw('SUM(val_frete) AS receita')
        )
            ->Search($this->filtros2)
            ->groupBy('ano', 'mes')
            ->get();

        foreach ($this->tableDistribuicao as $key => $td){
            $this->tableDistribuicao[$key]['% Total Qtde'] = $td->{'Qtde de CTRC'} * 100 / $tabela_auxiliar[0]->total;
            $this->tableDistribuicao[$key]['% Total Receita'] = $td->Receita * 100 / $tabela_auxiliar[0]->receita;
        }

        $this->tableDistribuicao = $this->tableDistribuicao->toArray();
    }


    public function render()
    {
        return view('livewire.components.analise-clientes.tabela-distribuicao');
    }

}
