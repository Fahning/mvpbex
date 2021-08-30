<?php

namespace App\Http\Livewire\Components\Movimentacoes;


use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use App\Models\TabelaChegada;
use Mediconesystems\LivewireDatatables\TimeColumn;

class Tabelachegadas extends LivewireDatatable
{
    public $filtros;

    protected $listeners = ['filtroMovimentacoes'];

    public function filtroMovimentacoes($filtros)
    {
        $this->filtros = $filtros;
    }

    public function builder(){
        return TabelaChegada::query()
            ->when($this->filtros, function ($query){
                if($this->filtros[0]){
                    $query->where('Destino', $this->filtros[0]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[1]){
                    $query->whereIn('Sigla Destino', $this->filtros[1]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[2]){
                    $query->where('Cliente', $this->filtros[2]);
                }
            })
            ;
    }

    public function columns()
    {
        return [
            Column::name('Sigla Origem'),
            Column::name('Origem'),
            Column::name('Sigla Destino'),
            Column::name('Destino'),
            Column::name('Tipo'),
            Column::name('Manifesto'),
            DateColumn::name('Emissão Manifesto'),
            DateColumn::name('Dia Saída'),
            TimeColumn::name('Hora Saída'),
            DateColumn::name('Previsão Chegada'),
            TimeColumn::name('Hora Chegada Prevista'),
            Column::name('Previsão Entrega'),
            Column::name('Placa'),
            Column::name('CTE'),
            Column::name('Cliente'),
            Column::callback('Cubagem', function ($value) {
                return formatM3($value);
            })->label('Cubagem'),
            Column::callback('Peso', function ($value) {
                return formatPeso($value);
            })->label('Peso'),
            Column::callback('Volumes', function ($value) {
                return number_format($value, 0, null, '.');
            })->label('Volumes'),
            Column::callback('Valor_mercadoria', function ($value) {
                return formatReceita($value);
            })->label('Valor Mercadoria'),
            Column::callback('Frete', function ($value) {
                return formatReceita($value);
            })->label('Frete'),
            Column::name('Entrega Programada'),
            Column::name('Última Ocorrência')->truncate(15),

        ];
    }
    public function cellClasses($row, $column)
    {
        return 'text-xs';
    }
    public function rowClasses($row, $column)
    {
        return 'text-xs';
    }
}
