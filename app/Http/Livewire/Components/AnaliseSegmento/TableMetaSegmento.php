<?php

namespace App\Http\Livewire\Components\AnaliseSegmento;

use App\Models\TabelaCtes;
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

        $media = DB::select("call calcula_media3(".Carbon::today()->year.", ".Carbon::today()->month.")");

        $faturamentos = TabelaCtes::select(
            'ano',
            'mes',
            DB::raw('SUM(val_frete) AS receita_total')
        )
            ->where('ano', Carbon::today()->year)
            ->where('mes', '<', Carbon::today()->month)
            ->where('mes','>=', Carbon::today()->subMonths(3)->month)
            ->groupBy('ano', 'mes')
            ->get();

        $this->table = TabelaCtes::select(
                'tabela_ctes.ano',
                'tabela_ctes.mes',
                'tabela_ctes.segmento',
                'dias_uteis',
                'dias_uteis_hoje',
                DB::raw('SUM(tabela_ctes.val_frete) AS Realizado')
            )
            ->leftJoin('meta_acumulada_dia', function ($join) {
                $join->on('tabela_ctes.ano', '=', 'meta_acumulada_dia.ano');
                $join->on('tabela_ctes.mes', '=', 'meta_acumulada_dia.mes');
            })
            ->where('tabela_ctes.ano', Carbon::today()->year)
            ->where('tabela_ctes.mes', '<', Carbon::today()->month)
            ->where('tabela_ctes.mes','>=', Carbon::today()->subMonths(3)->month)
            ->groupBy('tabela_ctes.ano', 'tabela_ctes.mes','segmento')
            ->get()
            ->toArray();

        $query = DB::raw("segmento AS Segmento,
                            SUM(val_frete) AS Realizado,
                            IF(((tabela_ctes.mes = MONTH(CURDATE()))
                                    AND (tabela_ctes.ano = YEAR(CURDATE()))),
                                (SUM(val_frete) / meta_acumulada_dia.dias_uteis_hoje),
                                (SUM(val_frete) / meta_acumulada_dia.dias_uteis)) AS Média,
                                meta_acumulada_dia.dias_uteis_hoje,
                                meta_acumulada_dia.dias_uteis
                                ");


        $tabelaFinal = TabelaCtes::select($query)
            ->leftJoin('meta_acumulada_dia', function ($join) {
                $join->on('tabela_ctes.ano', '=', 'meta_acumulada_dia.ano');
                $join->on('tabela_ctes.mes', '=', 'meta_acumulada_dia.mes');
            })
            ->where('tabela_ctes.mes', Carbon::today()->month)
            ->orderBy('segmento', 'desc')
            ->groupBy('segmento')
            ->get()
            ->toArray();

        # Recupera ultimos tres meses de cada segmento do val_frete e armazena em uma array
        $segmentos = [];
        foreach ($this->table as $key => $t){
            if(!in_array($t['segmento'], $segmentos)){
                array_push($segmentos, $t['segmento']);
            }
            foreach ($faturamentos as $f){

                if($t['mes'] == $f->mes && $t['ano'] == $f->ano){
                    $this->table[$key]['fator_peso'] = $t['Realizado'] / $f->receita_total;
                }
            }
        }

        # percorre tabela e calcula a media dos ultimos tres meses em segmento e salva em array $soma
        foreach ($segmentos as $segmento){
            foreach ($this->table as $key => $t){
                if(!isset($soma[$segmento])){
                    $soma[$segmento] = 0;
                }
                if($segmento == $t['segmento']){
                    $soma[$segmento] += floatval($this->table[$key]['fator_peso'] / 3);
                }
            }
         }

        # Percorrer as duas tabelas principais, calcular a media e o desvio e remover as colunas desnecessarias.
        foreach($tabelaFinal as $k => $tf){
            foreach ($soma as $key => $valor){
                if($tf['Segmento'] == $key){
                    $tabelaFinal[$k]['media_fator_peso'] = $valor;
                }
            }
            if($tf['dias_uteis_hoje'] == 0){
                $tabelaFinal[$k]['Meta'] = (floatval($soma[$tf['Segmento']]) * floatval($media[0]->vMedia));
            }else{
                $tabelaFinal[$k]['Meta'] = (floatval($soma[$tf['Segmento']]) * floatval($media[0]->vMedia)) * $tf['dias_uteis_hoje'] / $tf['dias_uteis'];
            }
            $tabelaFinal[$k]['Desvio (R$)'] = floatval($tf['Realizado']) - floatval($tabelaFinal[$k]['Meta']);
            if($this->maior < $tf['Realizado']){
                $this->maior = floatval($tf['Realizado']);
            }
            unset($tabelaFinal[$k]['fator_peso']);
            unset($tabelaFinal[$k]['dias_uteis']);
            unset($tabelaFinal[$k]['media_fator_peso']);
            unset($tabelaFinal[$k]['dias_uteis_hoje']);
        }
        $this->table = $tabelaFinal;

    }


    public function filtrar($filtro)
    {
        $filtro['ano'] = $filtro['ano'] ?? Carbon::today()->year;
        $filtro['mes'] = $filtro['mes'] ?? Carbon::today()->month;
        #Traz receita total para calcular media
        $count_mes = TabelaCtes::select(DB::raw('distinct(mes)'))
            ->where('mes', '<',  $filtro['mes'])
            ->where('mes','>=', Carbon::create($filtro['ano'],$filtro['mes'])->subMonths(3)->month)
            ->get();

        $media = $this->queryMedia3($filtro, $count_mes);

        $faturamentos = TabelaCtes::select(
            'ano',
            'mes',
            DB::raw('count(distinct(mes)) AS count_mes'),
            DB::raw('SUM(val_frete) AS receita_total')
        )
            ->where('ano', $filtro['ano'])
            ->when($filtro['searchBase'], function ($query) use($filtro) {
                $query->whereIn('und_emissora', $filtro['searchBase']);
            })
            ->where('mes', '<',  $filtro['mes'])
            ->where('mes','>=', Carbon::create($filtro['ano'],$filtro['mes'])->subMonths(3)->month)
            ->groupBy('ano', 'mes')
            ->get();
        $this->table = TabelaCtes::select(
            'tabela_ctes.ano',
            'tabela_ctes.mes',
            'tabela_ctes.segmento',
            'dias_uteis',
            'dias_uteis_hoje',
            DB::raw('SUM(tabela_ctes.val_frete) AS Realizado')
        )
            ->leftJoin('meta_acumulada_dia', function ($join) {
                $join->on('tabela_ctes.ano', '=', 'meta_acumulada_dia.ano');
                $join->on('tabela_ctes.mes', '=', 'meta_acumulada_dia.mes');
            })
            ->when($filtro['searchBase'], function ($query) use($filtro) {
                $query->whereIn('und_emissora', $filtro['searchBase']);
            })
            ->where('tabela_ctes.ano', $filtro['ano'])
            ->where('tabela_ctes.mes', '<',  $filtro['mes'])
            ->where('tabela_ctes.mes','>=', Carbon::create($filtro['ano'],$filtro['mes'])->subMonths(3)->month)
            ->groupBy('tabela_ctes.ano', 'tabela_ctes.mes','segmento')
            ->get()
            ->toArray();

        $query = DB::raw("segmento AS Segmento,
                            SUM(val_frete) AS Realizado,
                            IF(((tabela_ctes.mes = MONTH(CURDATE()))
                                    AND (tabela_ctes.ano = YEAR(CURDATE()))),
                                (SUM(val_frete) / meta_acumulada_dia.dias_uteis_hoje),
                                (SUM(val_frete) / meta_acumulada_dia.dias_uteis)) AS Média,
                                meta_acumulada_dia.dias_uteis_hoje,
                                meta_acumulada_dia.dias_uteis
                                ");


        $tabelaFinal = TabelaCtes::select($query)
            ->leftJoin('meta_acumulada_dia', function ($join) {
                $join->on('tabela_ctes.ano', '=', 'meta_acumulada_dia.ano');
                $join->on('tabela_ctes.mes', '=', 'meta_acumulada_dia.mes');
            })
            ->when($filtro['searchBase'], function ($query) use($filtro) {
                $query->whereIn('und_emissora', $filtro['searchBase']);
            })
            ->where('tabela_ctes.ano', $filtro['ano'])
            ->where('tabela_ctes.mes', $filtro['mes'])
            ->orderBy('segmento', 'desc')
            ->groupBy('segmento')
            ->get()
            ->toArray();

        # Recupera ultimos tres meses de cada segmento do val_frete e armazena em uma array
        $segmentos = [];
        foreach ($this->table as $key => $t){
            if(!in_array($t['segmento'], $segmentos)){
                array_push($segmentos, $t['segmento']);
            }
            foreach ($faturamentos as $f){

                if($t['mes'] == $f->mes && $t['ano'] == $f->ano){
                    $this->table[$key]['fator_peso'] = $t['Realizado'] / $f->receita_total;
                }
            }
        }

        # percorre tabela e calcula a media dos ultimos tres meses em segmento e salva em array $soma
        foreach ($segmentos as $segmento){
            foreach ($this->table as $key => $t){
                if(!isset($soma[$segmento])){
                    $soma[$segmento] = 0;
                }
                if($segmento == $t['segmento']){
                    $soma[$segmento] += floatval($this->table[$key]['fator_peso'] / count($count_mes));
                }
            }
        }

        # Percorrer as duas tabelas principais, calcular a media e o desvio e remover as colunas desnecessarias.
        foreach($tabelaFinal as $k => $tf){
            foreach ($soma as $key => $valor){
                if($tf['Segmento'] == $key){
                    $tabelaFinal[$k]['media_fator_peso'] = $valor;
                }
            }
            if($tf['dias_uteis_hoje'] == 0){
                $tabelaFinal[$k]['Meta'] = floatval($soma[$tf['Segmento']]) * $media;
            }else{
                $tabelaFinal[$k]['Meta'] = (floatval($soma[$tf['Segmento']]) * $media) * $tf['dias_uteis_hoje'] / $tf['dias_uteis'];
            }
            $tabelaFinal[$k]['Desvio (R$)'] = floatval($tf['Realizado']) - floatval($tabelaFinal[$k]['Meta']);
            if($this->maior < $tf['Realizado']){
                $this->maior = floatval($tf['Realizado']);
            }
            unset($tabelaFinal[$k]['fator_peso']);
            unset($tabelaFinal[$k]['dias_uteis']);
            unset($tabelaFinal[$k]['media_fator_peso']);
            unset($tabelaFinal[$k]['dias_uteis_hoje']);
        }
        $this->table = $tabelaFinal;

        if(!is_null($filtro['orderDesvios'])){
            usort($this->table, function($a, $b) use($filtro)
            {
                if($filtro['orderDesvios'] == 'asc'){
                    return $a['Desvio (R$)'] > $b['Desvio (R$)'];
                }elseif($filtro['orderDesvios'] == 'desc'){
                    return $a['Desvio (R$)'] < $b['Desvio (R$)'];
                }else{
                    return $a['Desvio (R$)'];
                }
            });
        }


    }

    public function render()
    {

        return view('livewire.components.analise-segmento.table-meta-segmento');
    }


    protected function queryMedia3($filtro, $count_mes)
    {
        $filtro['ano'] = $filtro['ano'] ?? Carbon::today()->year;
        $filtro['mes'] = $filtro['mes'] ?? Carbon::today()->month;
        $table = TabelaCtes::select('ano', 'mes', DB::raw('SUM(val_frete) AS receita'))
            ->where('tabela_ctes.ano', $filtro['ano'])
            ->where('tabela_ctes.mes', '<', $filtro['mes'])
            ->when($filtro['searchBase'], function ($query) use($filtro){
                $query->whereIn('und_emissora', $filtro['searchBase']);
            })
            ->where('tabela_ctes.mes', '>=', Carbon::create($filtro['ano'], $filtro['mes'])->subMonths(3)->month)
            ->groupBy('mes')
            ->get();
        $media = 0;
        foreach ($table as $t) {
            $media += $t->receita / count($count_mes);
        }
        return $media;
    }

//    private function queryMetaSegment($month, $year, $segmentos = []){
//        /*
//                SELECT
//                    `nf`.`segmento` AS `Segmento`,
//                    SUM(`nf`.`val_frete`) AS `Realizado`,
//                    IF(((`nf`.`mes` = MONTH(CURDATE()))
//                            AND (`nf`.`ano` = YEAR(CURDATE()))),
//                        (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis_hoje`),
//                        (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis`)) AS `Média`,
//                    `mda`.`peso_base` AS `Fator Peso`,
//
//                FROM
//                    `tabela_ctes` `nf`
//                        LEFT JOIN
//                    (SELECT `ps`.`segmento`, AVG(`ps`.`peso_base`) as `peso_base` FROM (SELECT
//                        `nf`.`ano`,
//                            `nf`.`mes`,
//                            `nf`.`segmento` AS `segmento`,
//                            (SUM(`nf`.`val_frete`) / `tot`.`receita_total`) AS `peso_base`
//                    FROM
//                        (`tabela_ctes` `nf`
//                    LEFT JOIN (SELECT
//                        `nf`.`ano` AS `ano`,
//                            `nf`.`mes` AS `mes`,
//                            SUM(`nf`.`val_frete`) AS `receita_total`
//                    FROM
//                        `tabela_ctes` `nf`
//                    GROUP BY `nf`.`ano` , `nf`.`mes`) `tot` ON (((`nf`.`ano` = `tot`.`ano`)
//                        AND (`nf`.`mes` = `tot`.`mes`))))
//                    WHERE
//                        ((`nf`.`mes` < ".$month.")
//                            AND (`nf`.`mes` >= ".$month." - 3))
//                    GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`segmento`) as ps
//                    GROUP BY `ps`.`segmento`) `mda` ON `nf`.`segmento` = `mda`.`segmento`
//
// */
//        $teste = TabelaCtes::select(
//            'segmento',
//            DB::raw('SUM(val_frete) AS Realizado'),
//            'dias_uteis_hoje',
//            'dias_uteis'
//        )
//            ->leftJoin('meta_acumulada_dia', function ($join) {
//                $join->on('tabela_ctes.ano', '=', 'meta_acumulada_dia.ano');
//                $join->on('tabela_ctes.mes', '=', 'meta_acumulada_dia.mes');
//            })
////            ->where('ano', Carbon::today()->year)
////            ->where('mes', '<', Carbon::today()->month)
////            ->where('mes','>=', Carbon::today()->subMonths(3)->month)
//            ->groupBy('segmento')
//            ->get()
//            ->toArray();
//        return DB::select("SELECT
//                            `nf`.`segmento` AS `Segmento`,
//                            SUM(`nf`.`val_frete`) AS `Realizado`,
//                            IF(((`nf`.`mes` = MONTH(CURDATE()))
//                                    AND (`nf`.`ano` = YEAR(CURDATE()))),
//                                (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis_hoje`),
//                                (SUM(`nf`.`val_frete`) / `mad`.`dias_uteis`)) AS `Média`,
//                            `mda`.`peso_base` AS `Fator Peso`,
//                            `mad`.`dias_uteis_hoje`,
//                            `mad`.`dias_uteis`
//                        FROM
//                            `tabela_ctes` `nf`
//                                LEFT JOIN
//                            (SELECT `ps`.`segmento`, AVG(`ps`.`peso_base`) as `peso_base` FROM (SELECT
//                                `nf`.`ano`,
//                                    `nf`.`mes`,
//                                    `nf`.`segmento` AS `segmento`,
//                                    (SUM(`nf`.`val_frete`) / `tot`.`receita_total`) AS `peso_base`
//                            FROM
//                                (`tabela_ctes` `nf`
//                            LEFT JOIN (SELECT
//                                `nf`.`ano` AS `ano`,
//                                    `nf`.`mes` AS `mes`,
//                                    SUM(`nf`.`val_frete`) AS `receita_total`
//                            FROM
//                                `tabela_ctes` `nf`
//                            GROUP BY `nf`.`ano` , `nf`.`mes`) `tot` ON (((`nf`.`ano` = `tot`.`ano`)
//                                AND (`nf`.`mes` = `tot`.`mes`))))
//                            WHERE
//                                ((`nf`.`mes` < ".$month.")
//                                    AND (`nf`.`mes` >= ".$month." - 3))
//                            GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`segmento`) as ps
//                            GROUP BY `ps`.`segmento`) `mda` ON `nf`.`segmento` = `mda`.`segmento`
//                                LEFT JOIN
//                            `meta_acumulada_dia` `mad` ON (((`nf`.`ano` = `mad`.`ano`)
//                                AND (`nf`.`mes` = `mad`.`mes`)))
//                        WHERE
//                            `nf`.`ano` = ".$year." AND `nf`.`mes` = ".$month." ".$segmentos."
//                        GROUP BY `nf`.`ano` , `nf`.`mes` , `nf`.`segmento`
//                        ORDER BY Realizado desc
//                        ");
//    }
}
