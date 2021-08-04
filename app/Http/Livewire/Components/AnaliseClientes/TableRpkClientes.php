<?php

namespace App\Http\Livewire\Components\AnaliseClientes;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableRpkClientes extends Component
{
    public $tableRpkClientes;
    public $year;
    public $month;

    public $maior = 0;

    protected $listeners = ['filtros' => 'filtrar'];

    public function mount()
    {
        $this->year = Carbon::today()->year;
        $this->month = Carbon::today()->month;
        $this->tableRpkClientes = DB::table('v_indic_cliente')
            ->select('Cliente', 'TKM', 'RPK', '% Frete/Valor Mercadoria', 'Qtde CTRC')
            ->where('ano', $this->year)
            ->where('mes', $this->month)
            ->orderBy('Qtde CTRC', 'desc')
            ->get();
        foreach ($this->tableRpkClientes as $t){
            if($this->maior < $t->{"Qtde CTRC"}){
                $this->maior = $t->{"Qtde CTRC"};
            }
        }
    }

    public function filtrar($filtro)
    {
        $this->year = $filtro['ano'];
        $this->month = $filtro['mes'];
        $this->tableRpkClientes = DB::table('v_indic_cliente')
            ->select('Cliente', 'TKM', 'RPK', '% Frete/Valor Mercadoria', 'Qtde CTRC')
            ->where('ano', $this->year)
            ->where('mes', $this->month)
            ->when($filtro['searchCliente'], function($query) use($filtro) {
                $query->where('Cliente','like', "%{$filtro['searchCliente']}%");
            })
            ->orderBy('Qtde CTRC', 'desc')
            ->get();

        foreach ($this->tableRpkClientes as $t){
            if($this->maior < $t->{"Qtde CTRC"}){
                $this->maior = $t->{"Qtde CTRC"};
            }
        }
    }

    public function render()
    {

        return view('livewire.components.analise-clientes.table-rpk-clientes');
    }
}
