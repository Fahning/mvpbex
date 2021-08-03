<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMetaSegmento extends Component
{
    public $table;
    public $year;
    public $month;
    public $maior = 0;
    public $selectSegmentos = [];
    public $segmentolist = [];

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");

        if(!empty($this->selectSegmentos)){
            foreach($this->selectSegmentos as $b){
                array_push($segmento, $b['id'] );
            }
            $segmento = "'" . implode ( "', '", $segmento ) . "'";
            $segmento = "AND nf.segmento IN ({$segmento})";
        }else{
            $segmento = '';
        }
        $this->table = $this->queryMetaSegment($this->month, $this->year, $segmento);
        foreach ($this->table as $t){
            $t->Meta = floatval($t->{'Fator Peso'}) * floatval($media[0]->vMedia);
            array_push($this->segmentolist,$t->Segmento );
            unset($t->{'Fator Peso'});
            if($this->maior < $t->Realizado){
                $this->maior = $t->Realizado;
            }
        }
    }


    public function searchSegmentos()
    {

        $this->media = DB::select("call calcula_media3(".$this->year.", ".$this->month.")");

        $this->table = $this->queryMetaSegment($this->month, $this->year);
        dd($this->table);

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

        $segmentos = [];
        if(!empty($filtro['searchSegmentos'])){
            foreach($filtro['searchSegmentos'] as $b){
                array_push($segmentos, $b);
            }
            $segmentos = "'" . implode ( "', '", $segmentos ) . "'";
            $segmentos = "AND nf.segmento IN ({$segmentos})";
        }else{
            $segmentos = '';
        }


        $this->table = $this->queryMetaSegment($this->month, $this->year, $segmentos);

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

        return view('livewire.components.analise-segmento.table-meta-segmento');
    }




    private function queryMetaSegment($month, $year, $segmentos = []){
        return DB::select("SELECT
                            `nf`.`segmento` AS `Segmento`,
                            SUM(`nf`.`val_frete`) AS `Realizado`,
                            IF(((`nf`.`mes` = MONTH(CURDATE()))
                                    AND (`nf`.`ano` = YEAR(CURDATE()))),
                                (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis_hoje`),
                                (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis`)) AS `Média`,
                            `mda`.`peso_base` AS `Fator Peso`
                        FROM
                            `tabela_ctes` `nf`
                                LEFT JOIN
                            (SELECT `ps`.`segmento`, AVG(`ps`.`peso_base`) as `peso_base` FROM (SELECT
                                `nf`.`ano`,
                                    `nf`.`mes`,
                                    `nf`.`segmento` AS `segmento`,
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
                            GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`segmento`) as ps
                            GROUP BY `ps`.`segmento`) `mda` ON `nf`.`segmento` = `mda`.`segmento`
                                LEFT JOIN
                            `meta_acumulada_dia` `mad` ON (((`nf`.`ano` = `mad`.`ano`)
                                AND (`nf`.`mes` = `mad`.`mes`)))
                        WHERE
                            `nf`.`ano` = ".$year." AND `nf`.`mes` = ".$month." ".$segmentos."
                        GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`segmento`");
//        return DB::select("SELECT
//                            nf.segmento AS Segmento,
//                            SUM(nf.val_frete) AS Realizado,
//                            IF(((nf.mes = MONTH(CURDATE()))
//                                    AND (nf.ano = YEAR(CURDATE()))),
//                                (SUM(nf.val_frete) / mad.dias_uteis_hoje),
//                                (SUM(nf.val_frete) / mad.dias_uteis)) AS Média,
//                            AVG(mda.peso_base) AS 'Fator Peso'
//                        FROM
//                            tabela_ctes nf
//
//                        LEFT JOIN (SELECT
//                            nf.ano,
//                            nf.mes,
//                            nf.segmento AS segmento,
//                            (SUM(nf.val_frete) / tot.receita_total) AS peso_base
//                        FROM
//                            (tabela_ctes nf
//                            LEFT JOIN (SELECT
//                                nf.ano AS ano,
//                                    nf.mes AS mes,
//                                    SUM(nf.val_frete) AS receita_total
//                            FROM
//                                tabela_ctes nf
//                            GROUP BY nf.ano , nf.mes) tot ON (((nf.ano = tot.ano)
//                                AND (nf.mes = tot.mes))))
//                        WHERE
//                            ((nf.mes < ".$month.")
//                                AND (nf.mes >= ".$month." - 3))
//                        GROUP BY nf.ano, nf.mes, nf.segmento) mda
//                        ON nf.segmento = mda.segmento
//
//                    LEFT JOIN meta_acumulada_dia mad ON (((nf.ano = mad.ano)
//                    AND (nf.mes = mad.mes)))
//
//
//                        WHERE nf.ano = ".$year." AND nf.mes = ".$month ." ".$segmentos."
//
//                        GROUP BY nf.ano , nf.mes , nf.segmento;");
    }
}
