<?php

namespace App\Http\Livewire\Layout;

use App\Models\Insight;
use App\Models\Insights;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class MenuTop extends Component
{
    public $avatar;
    public $insights = 0;

    protected $listeners = [
        'refresh-navigation-menu' => 'refreshAvatar'
    ];

    public function mount()
    {
        $this->avatar = [
            'avatar'    => Cookie::get('photo'),
            'name'      => Cookie::get('name')
        ];
        $this->insights = Insights::where('status', 0)->get();
    }

    public function refreshAvatar()
    {
        $this->avatar = Cookie::get('photo');
    }
    public function render()
    {
        return view('livewire.layout.menu-top');
    }
}
