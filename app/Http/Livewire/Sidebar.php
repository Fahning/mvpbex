<?php

namespace App\Http\Livewire;

use App\Models\Insights;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{

    public $slot;
    public $insights = 0;


    public function mount()
    {
//        dd(Insights::where('status', 0)->get());
        $this->insights = Insights::where('status', 0)->get();
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
