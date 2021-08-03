<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaClientes extends Component
{
    public $table;
    public $month;
    public $year;
    public $maior = 0;
    public $clientes = '';

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");


        $this->table = $this->queryMetaClientes($this->month, $this->year);

        foreach ($this->table as $t){
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

    public function seachClientes()
    {

        $this->media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        if(!empty($this->clientes)){
            $clientes = "AND nf.nome_pagador LIKE '%{$this->clientes}%'";
        }else{
            $clientes = '';
        }

        $this->table = $this->queryMetaClientes($this->month, $this->year);

        foreach ($this->table as $t){
            $t->Meta = (floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia)) * $t->dias_uteis_hoje / $t->dias_uteis;
            $t->{'Desvio (R$)'} = floatval($t->{'Realizado'}) - floatval($t->{'Meta'});
            unset($t->{'Fator Peso'});
            unset($t->dias_uteis_hoje);
            unset($t->dias_uteis);
        }
    }



    public function filtrar($filtro)
    {
        if(!empty($filtro['searchCliente'])){
            $cliente = "AND nf.nome_pagador LIKE '%".$filtro['searchCliente']."%'";
        }else{
            $cliente = '';
        }

        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");

        $this->table = $this->queryMetaClientes($this->month, $this->year, $cliente);
        foreach ($this->table as $t){
            $t->Meta = (floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia)) * $t->dias_uteis_hoje / $t->dias_uteis;
            $t->{'Desvio (R$)'} = floatval($t->{'Realizado'}) - floatval($t->{'Meta'});
            unset($t->{'Fator Peso'});
            unset($t->dias_uteis_hoje);
            unset($t->dias_uteis);
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }

        if(!is_null($filtro['orderDesvios'])){
            usort($this->table, function($a, $b) use($filtro)
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
        return view('livewire.components.analise-clientes.table-meta-clientes');
    }



    private function queryMetaClientes($month, $year, $cliente = '')
    {
        return DB::select("
                    SELECT
                `nf`.`nome_pagador` AS `Cliente`,
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
                (SELECT `ps`.`nome_pagador`, AVG(`ps`.`peso_base`) as `peso_base` FROM (SELECT
                    `nf`.`ano`,
                        `nf`.`mes`,
                        `nf`.`nome_pagador` AS `nome_pagador`,
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
                GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`nome_pagador`) as ps
                GROUP BY `ps`.`nome_pagador`) `mda` ON `nf`.`nome_pagador` = `mda`.`nome_pagador`
                    LEFT JOIN
                `meta_acumulada_dia` `mad` ON (((`nf`.`ano` = `mad`.`ano`)
                    AND (`nf`.`mes` = `mad`.`mes`)))
            WHERE
                `nf`.`ano` = ".$year." AND `nf`.`mes` = ".$month." ".$cliente."
            GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`nome_pagador`
        ");
    }
}
