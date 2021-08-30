<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use App\Models\ViewAgendamentos;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\TimeColumn;

class TabelaAgendamentos extends LivewireDatatable
{
    public $filtros;

    protected $listeners = ['filtroMovimentacoes'];


    public function filtroMovimentacoes($filtros)
    {
        $this->filtros = $filtros;
    }

    public function builder()
    {
        return ViewAgendamentos::query()
            ->when($this->filtros, function ($query){
                if($this->filtros[0]){
                    $query->where('cidade', $this->filtros[0]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[1]){
                    $query->whereIn('Unidade Receptora', $this->filtros[1]);
                }
            })
            ->when($this->filtros, function ($query){
                if($this->filtros[2]){
                    $query->where('Cliente', $this->filtros[2]);
                }
            })
            ;
    }

    public function columns(): array
    {
        return [
            Column::name('CTE'),
            Column::name('Emissão CTE'),
            Column::name('Cliente'),
            Column::name('Unidade Receptora'),
            Column::name('Último Manifesto'),
            Column::name('Destino Manifesto'),
            DateColumn::name('Dia Chegada Manifesto'),
            TimeColumn::name('Hora Chegada Manifesto'),
            Column::name('Data Prevista Chegada'),
            TimeColumn::name('Hora Prevista Chegada'),
            Column::callback('Cubagem', function ($value) {
                return formatM3($value);
            })->label('Cubagem'),
            Column::callback('Peso', function ($value) {
                return formatPeso($value);
            })->label('Peso'),
            Column::callback('Volumes', function ($value) {
                return number_format($value, 0, null, '.');
            })->label('Volumes'),
            Column::callback('(R$) Mercadoria', function ($value) {
                return formatReceita($value);
            })->label('(R$) Mercadoria'),
            Column::callback('(R$) Frete', function ($value) {
                return formatReceita($value);
            })->label('(R$) Frete'),
            Column::name('Previsao Entrega')->label('Previsão Entrega'),
            Column::name('Entrega Programada'),
            Column::name('Última Ocorrência')->truncate(15),
        ];
    }
}
