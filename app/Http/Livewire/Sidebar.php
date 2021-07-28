<?php

namespace App\Http\Livewire;

use App\Models\Insights;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{

    public $slot;


    public function mount()
    {
        $this->avatar = Auth::user()->profile_photo_url ?? '';
        $this->insights = Insights::where('status', 0)->get();
    }

    public function toOperacional()
    {
        return redirect()->to('/operacional');
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
