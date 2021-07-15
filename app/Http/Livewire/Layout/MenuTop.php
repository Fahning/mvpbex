<?php

namespace App\Http\Livewire\Layout;

use App\Models\Insights;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MenuTop extends Component
{
    public $avatar;
    public $insights = 0;

    protected $listeners = ['refresh-navigation-menu' => 'refreshAvatar'];

    public function mount()
    {
        $this->avatar = [
            'avatar' => Auth::user()->profile_photo_url,
            'name'      =>Auth::user()->name
        ];
        $this->insights = Insights::where('status', 0)->get();
    }
    public function abreModal($id){
        $this->emit('mostraModal', $id);
    }

    public function refreshAvatar()
    {
        $this->avatar = Auth::user()->profile_photo_url;
    }
    public function render()
    {
        return view('livewire.layout.menu-top');
    }
}
