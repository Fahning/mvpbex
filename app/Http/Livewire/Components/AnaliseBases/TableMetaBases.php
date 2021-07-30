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
    public $selectBases = [];
    public $baselist = [];

    protected $media;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount(){
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;

        $this->media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");

        $this->tableMetaBases = DB::select("SELECT
        nf.und_emissora AS Base,
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
        nf.und_emissora AS base,
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
    GROUP BY nf.ano, nf.mes, nf.und_emissora) mda
    ON nf.und_emissora = mda.base

LEFT JOIN meta_acumulada_dia mad ON (((nf.ano = mad.ano)
AND (nf.mes = mad.mes)))


    WHERE nf.ano = ".$this->year." AND nf.mes = ".$this->month ."

    GROUP BY nf.ano , nf.mes , nf.und_emissora;");

        foreach ($this->tableMetaBases as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($this->media[0]->vMedia);
            array_push($this->baselist,$t->Base );
            unset($t->{'Fator Peso'});
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }

    }

    public function searchBases()
    {
        $this->media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        $base = [];
        if(!empty($this->selectBases)){
            foreach($this->selectBases as $b){
                array_push($base, $b );
            }
            $base = "'" . implode ( "', '", $base ) . "'";
            $base = "AND nf.und_emissora IN ({$base})";
        }else{
            $base = '';
        }

        $this->tableMetaBases = DB::select("SELECT
                            nf.und_emissora AS Base,
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
                            nf.und_emissora AS base,
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
                        GROUP BY nf.ano, nf.mes, nf.und_emissora) mda
                        ON nf.und_emissora = mda.base

                    LEFT JOIN meta_acumulada_dia mad ON (((nf.ano = mad.ano)
                    AND (nf.mes = mad.mes)))


                        WHERE nf.ano = ".$this->year." AND nf.mes = ".$this->month ." ".$base."

                        GROUP BY nf.ano , nf.mes , nf.und_emissora;");

        foreach ($this->tableMetaBases as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($this->media[0]->vMedia);
            unset($t->{'Fator Peso'});
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");
        $this->tableMetaBases = DB::select("CALL tabelas_filtros(".$this->year.", ".$this->month.",'Base')");
        foreach ($this->tableMetaBases as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia);
            unset($t->{'Fator Peso'});
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }

    public function render()
    {
        return view('livewire.components.analise-bases.table-meta-bases');
    }
}
