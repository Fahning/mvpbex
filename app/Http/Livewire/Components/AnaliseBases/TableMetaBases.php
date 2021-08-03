<?php

namespace App\Http\Livewire\Components\AnaliseBases;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaBases extends Component
{
    public $tableMetaBases;
    public $year;
    public $month;
    public $maior = 0;


    protected $listeners = ['filtros' => 'filtrar'];

    public function mount(){
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;

        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");

        $this->tableMetaBases = $this->queryMetaBases($this->month, $this->year);

        foreach ($this->tableMetaBases as $t){
            $t->Meta = (floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia)) * $t->dias_uteis_hoje / $t->dias_uteis;
            $t->{'Desvio (R$)'} = floatval($t->{'Realizado'}) - floatval($t->{'Meta'});
            unset($t->{'Fator Peso'});
            unset($t->dias_uteis_hoje);
            unset($t->dias_uteis);
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }

    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        $base = [];
        if(!empty($filtro['searchBase'])){
            foreach($filtro['searchBase'] as $b){
                array_push($base, $b );
            }
            $base = "'" . implode ( "', '", $base ) . "'";
            $base = "AND nf.und_emissora IN ({$base})";
        }else{
            $base = '';
        }

        $this->tableMetaBases = $this->queryMetaBases($this->month, $this->year, $base);

        foreach ($this->tableMetaBases as $t){
            $t->Meta = (floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia)) * $t->dias_uteis_hoje / $t->dias_uteis;
            $t->{'Desvio (R$)'} = floatval($t->{'Realizado'}) - floatval($t->{'Meta'});
            unset($t->{'Fator Peso'});
            unset($t->dias_uteis_hoje);
            unset($t->dias_uteis);
        }

        if(!is_null($filtro['orderDesvios'])){
            usort($this->tableMetaBases, function($a, $b) use($filtro)
            {
                if($filtro['orderDesvios'] == 'asc'){
                    return $a->{'Desvio (R$)'} > $b->{'Desvio (R$)'};
                }elseif($filtro['orderDesvios'] == 'desc'){
                    return $a->{'Desvio (R$)'} < $b->{'Desvio (R$)'};
                }else{
                    return $a->{'Desvio (R$)'};
                }
            });
        }
    }


    public function render()
    {
        return view('livewire.components.analise-bases.table-meta-bases');
    }


    private function queryMetaBases($month, $year, $bases = ''): array
    {
        return DB::select("SELECT
                        `nf`.`und_emissora` AS `Base`,
                        SUM(`nf`.`val_frete`) AS `Realizado`,
                        IF(((`nf`.`mes` = MONTH(CURDATE()))
                                AND (`nf`.`ano` = YEAR(CURDATE()))),
                            (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis_hoje`),
                            (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis`)) AS `Média`,
                        `mda`.`peso_base` AS `Fator Peso`,
                        `mad`.`dias_uteis_hoje`,
                        `mad`.`dias_uteis`

                    FROM
                        `tabela_ctes` `nf`
                            LEFT JOIN
                        (SELECT `ps`.`und_emissora`, AVG(`ps`.`peso_base`) as `peso_base` FROM (SELECT
                            `nf`.`ano`,
                                `nf`.`mes`,
                                `nf`.`und_emissora` AS `und_emissora`,
                                (SUM(`nf`.`val_frete`) / `tot`.`receita_total`) AS `peso_base`
                        FROM
                            (`tabela_ctes` `nf`
                        LEFT JOIN (SELECT
                            `nf`.`ano` AS `ano`,
                                `nf`.`mes` AS `mes`,
                                SUM(`nf`.`val_frete`) AS `receita_total`
                        FROM
                            `tabela_ctes` `nf`
                        GROUP BY `nf`.`ano` , `nf`.`mes`) `tot` ON (((`nf`.`ano` = `tot`.`ano`)
                            AND (`nf`.`mes` = `tot`.`mes`))))
                        WHERE
                            ((`nf`.`mes` < ".$month.")
                                AND (`nf`.`mes` >= ".$month." - 3))
                        GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`und_emissora`) as ps
                        GROUP BY `ps`.`und_emissora`) `mda` ON `nf`.`und_emissora` = `mda`.`und_emissora`
                            LEFT JOIN
                        `meta_acumulada_dia` `mad` ON (((`nf`.`ano` = `mad`.`ano`)
                            AND (`nf`.`mes` = `mad`.`mes`)))
                    WHERE
                        `nf`.`ano` = ".$year." AND `nf`.`mes` = ".$month." ".$bases."
                    GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`und_emissora`");
    }
}
