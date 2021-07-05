<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{

    public $avatar;

    protected $listeners = ['refresh-navigation-menu' => 'refreshAvatar'];

    public function mount()
    {
        $this->avatar = Auth::user()->profile_photo_url;
    }

    public function refreshAvatar()
    {
        $this->avatar = Auth::user()->profile_photo_url;
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
