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
//        $this->table = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Cliente')");

        $this->table = DB::select("SELECT
                                nf.nome_pagador AS Clientes,
                                SUM(nf.val_frete) AS Realizado,
                                IF(((nf.mes = MONTH(CURDATE()))
                                        AND (nf.ano = YEAR(CURDATE()))),
                                    (SUM(nf.val_frete) / mad.dias_uteis_hoje),
                                    (SUM(nf.val_frete) / mad.dias_uteis)) AS Média,
                                AVG(mda.peso_base) AS 'Fator Peso'
                            FROM
                                tabela_ctes nf

                            LEFT JOIN (SELECT
                                nf.ano,
                                nf.mes,
                                nf.nome_pagador AS cliente,
                                (SUM(nf.val_frete) / tot.receita_total) AS peso_base
                            FROM
                                (tabela_ctes nf
                                LEFT JOIN (SELECT
                                    nf.ano AS ano,
                                        nf.mes AS mes,
                                        SUM(nf.val_frete) AS receita_total
                                FROM
                                    tabela_ctes nf
                                GROUP BY nf.ano , nf.mes) tot ON (((nf.ano = tot.ano)
                                    AND (nf.mes = tot.mes))))
                            WHERE
                                ((nf.mes < ".$this->month.")
                                    AND (nf.mes >= ".$this->month." - 3))
                            GROUP BY nf.ano, nf.mes, nf.nome_pagador) mda
                            ON nf.nome_pagador = mda.cliente

                        LEFT JOIN meta_acumulada_dia mad ON (((nf.ano = mad.ano)
                        AND (nf.mes = mad.mes)))


                            WHERE nf.ano = ".$this->year." AND nf.mes = ".$this->month ." ".$this->clientes."

    GROUP BY nf.ano , nf.mes , nf.nome_pagador;");

        foreach ($this->table as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia);
            unset($t->{'Fator Peso'});
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

        $this->table = DB::select("SELECT
                                nf.nome_pagador AS Clientes,
                                SUM(nf.val_frete) AS Realizado,
                                IF(((nf.mes = MONTH(CURDATE()))
                                        AND (nf.ano = YEAR(CURDATE()))),
                                    (SUM(nf.val_frete) / mad.dias_uteis_hoje),
                                    (SUM(nf.val_frete) / mad.dias_uteis)) AS Média,
                                AVG(mda.peso_base) AS 'Fator Peso'
                            FROM
                                tabela_ctes nf

                            LEFT JOIN (SELECT
                                nf.ano,
                                nf.mes,
                                nf.nome_pagador AS cliente,
                                (SUM(nf.val_frete) / tot.receita_total) AS peso_base
                            FROM
                                (tabela_ctes nf
                                LEFT JOIN (SELECT
                                    nf.ano AS ano,
                                        nf.mes AS mes,
                                        SUM(nf.val_frete) AS receita_total
                                FROM
                                    tabela_ctes nf
                                GROUP BY nf.ano , nf.mes) tot ON (((nf.ano = tot.ano)
                                    AND (nf.mes = tot.mes))))
                            WHERE
                                ((nf.mes < ".$this->month.")
                                    AND (nf.mes >= ".$this->month." - 3))
                            GROUP BY nf.ano, nf.mes, nf.nome_pagador) mda
                            ON nf.nome_pagador = mda.cliente

                        LEFT JOIN meta_acumulada_dia mad ON (((nf.ano = mad.ano)
                        AND (nf.mes = mad.mes)))


                            WHERE nf.ano = ".$this->year." AND nf.mes = ".$this->month ." ".$clientes."

    GROUP BY nf.ano , nf.mes , nf.nome_pagador;");

        foreach ($this->table as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($this->media[0]->vMedia);
            unset($t->{'Fator Peso'});
        }
    }



    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        $this->table = DB::select("call tabelas_filtros(".$this->year.", ".$this->month.",'Cliente')");
        foreach ($this->table as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia);
            unset($t->{'Fator Peso'});
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-clientes.table-meta-clientes');
    }
}
