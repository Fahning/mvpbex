<?php

namespace App\Http\Livewire\Components\Inventario;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TableInventario extends Component
{
    use WithPagination;

    public $buscar = null;
    public $situacao = null;
    public $tipo = null;
    public $processo = null;
    public $periodo = null;
    public $dataStart = null;
    public $dataEnd = null;
    public $ano = null;
    public $mes = null;
    public $trimestre = null;
    public $selectPeriodo = null;


    public function render()
    {
        return view('livewire.components.inventario.table-inventario', [
            'table' => DB::table('tabela_ctes')
                ->leftJoin('relacao_ocorrencias', 'ult_cod', '=', 'codigo')
                ->leftJoin('relacao_unidade_local', 'und_ocor', '=', 'sigla')
                ->whereNotIn('tabela_ctes.ult_cod', [1,12,19,22,32,35,34])->take(10)->select(
                    [
                        'tabela_ctes.ctrc as CTRC',
                        'tabela_ctes.data_emissao as Emissao',
                        'tabela_ctes.data_inclu_ocor as Data-Inclusão',
                        'relacao_ocorrencias.descricao as Descrição',
                        'tabela_ctes.data_ocor as Ocorrência',
                        'tabela_ctes.und_ocor as Base',
                        'relacao_unidade_local.cidade as Cidade-Base',
                        'tabela_ctes.local_atual as Local Atual',
                    ]
                )
                ->when($this->buscar, function($query) {
                    $query->where(function($q) {
                        $q->where('ctrc', 'like', "%".trim($this->buscar)."%")
                            ->orWhere('und_ocor', 'like', "%".trim($this->buscar)."%"."%");
                    });
                })
                ->when($this->situacao, function($query) {
                    if($this->situacao == 1){
                        return $query->where('previsao_entrega', '<', Carbon::today())->WhereNull('data_entrega_realizada');
                    }elseif($this->situacao == 2){
                        return $query->whereNotNull('entrega_programada')->whereNull('data_entrega_realizada');
                    }else{
                        return $query;
                    }
                })
                ->when($this->tipo, function($query) {
                     return $query->where('tipo','=', $this->tipo);
                })
                ->when($this->processo, function($query) {
                    return $query->where('processo', $this->processo);
                })
                ->when($this->ano && $this->selectPeriodo == 3, function($query) {
                    return $query->whereYear('data_inclu_ocor', $this->ano);
                })
                ->when($this->trimestre && $this->selectPeriodo == 2, function($query) {
                    if($this->trimestre === "1"){
                        return $query->whereBetween('data_inclu_ocor', [Carbon::create($this->ano,1),Carbon::create($this->ano,3, 31)]);
                    }elseif($this->trimestre === "2"){
                        return $query->whereBetween('data_inclu_ocor', [Carbon::create($this->ano,4),Carbon::create($this->ano,6, 31)]);
                    }elseif($this->trimestre === "3"){
                        return $query->whereBetween('data_inclu_ocor', [Carbon::create($this->ano,7),Carbon::create($this->ano,9, 31)]);
                    }elseif($this->trimestre === "4"){
                        return $query->whereBetween('data_inclu_ocor', [Carbon::create($this->ano,10),Carbon::create($this->ano,12, 31)]);
                    }else{
                        return $query;
                    }
                })
                ->when($this->mes && $this->selectPeriodo == 1, function($query) {
                    return $query->whereBetween('data_inclu_ocor', [Carbon::create($this->ano,$this->mes),Carbon::create($this->ano,$this->mes, 31)]);
                })
                ->when($this->dataStart && $this->selectPeriodo == 0, function($query) {
                    return $query->whereDate('data_inclu_ocor', '>', $this->dataStart);
                })
                ->when($this->dataEnd && $this->selectPeriodo == 0, function($query) {
                    return $query->whereDate('data_inclu_ocor', '<', $this->dataEnd);
                })
                ->paginate(10)
        ]);
    }
}


