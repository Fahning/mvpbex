<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;

class FiltersButtom extends Component
{
    public $month;
    public $year;
    public $years;



    public function mount()
    {
        $this->years = range(2000, Carbon::today()->year);
    }

    public function filtrar()
    {
        $filtros = [
            'month' => $this->month == null ? Carbon::today()->month : $this->month,
            'year' => $this->year  == null ? Carbon::today()->year : $this->year
        ];
        $this->emit('emitFiltros', $filtros);
    }

    public function render()
    {
        return view('livewire.components.filters-buttom');
    }


}
