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
    public $cardInsight = false;
    public $insight;
    public $insightModal;

    protected $listeners = [
        'refresh-navigation-menu' => 'refreshAvatar',
        'carregaInsight'
    ];

    public function mount()
    {
        $this->avatar = [
            'avatar'    => Cookie::get('photo'),
            'name'      => Cookie::get('name')
        ];
        $this->insights = Insights::where('status', 0)->get();
    }
    public function abreModal($id){
        $this->emit('mostraModal', $id);
    }

    public function carregaInsight(Insights $insight) {
        dd($insight);
        $ins = Insight::find($insight->insight_id);
        if(!empty($ins)){
            $this->insightModal = [
                'descricao' => $insight->descricao,
                'faturamento' => json_decode($ins->faturamento_ultimos_tres_meses),
                'chart_um' => json_decode($ins->chart_um),
                'chart_dois' => json_decode($ins->chart_dois),
                'chart_tres' => json_decode($ins->chart_tres)
            ];
        }else{
            $this->insightModal = [
                'descricao' => '',
                'faturamento' => '',
                'chart_um' => '',
                'chart_dois' => '',
                'chart_tres' => ''
            ];
        }
        $this->dispatchBrowserEvent('abreModal', ['abreModal' => true]);
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
