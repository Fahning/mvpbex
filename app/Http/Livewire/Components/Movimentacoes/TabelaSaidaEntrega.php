<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use App\Models\TabelaSaidaEntregas;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\TimeColumn;

class TabelaSaidaEntrega extends LivewireDatatable
{
    public $filtros;

    protected $listeners = ['filtroMovimentacoes'];

    public function filtroMovimentacoes($filtros)
    {
        $this->filtros = $filtros;
    }

    public function builder(){
        return TabelaSaidaEntregas::query()
            ->when($this->filtros, function ($query){
                if($this->filtros[0]){
                    $query->where('cidade_base', $this->filtros[0]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[1]){
                    $query->whereIn('unidade_receptora', $this->filtros[1]);
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
            Column::name('CTE'),
            Column::name('Emissão CTE'),
            Column::name('Setor Destino'),
            Column::name('Cliente')->truncate(15),
            Column::name('Placa'),
            Column::callback('Peso', function ($value) {
                return formatPeso($value);
            })->label('Peso'),
            Column::callback('Cubagem', function ($value) {
                return formatM3($value);
            })->label('Cubagem'),
            Column::callback('Volumes', function ($value) {
                return number_format($value, 0, null, '.');
            })->label('Volumes'),
            Column::callback('(R$) Mercadoria', function ($value) {
                return formatReceita($value);
            })->label('(R$) Mercadoria'),
            Column::callback('(R$) Frete', function ($value) {
                return formatReceita($value);
            })->label('(R$) Frete'),
            Column::name('Último Manifesto'),
            DateColumn::name('Dia Chegada Manifesto'),
            TimeColumn::name('Hora Chegada Manifesto'),
            Column::name('Última Tentativa Entrega'),
            Column::name('Última Ocorrência')->truncate(15),
            Column::name('Data Última Ocorrência'),
            Column::name('Previsão Entrega'),
            Column::name('Entrega Programada'),
            Column::name('Dias de Atraso'),
            Column::name('Localização Atual')
            ->truncate(15),
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
