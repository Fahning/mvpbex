<?php

namespace App\Http\Livewire\Components\Menus;

use App\Models\Insight;
use App\Models\Insights;
use Carbon\Carbon;
use Livewire\Component;

class ModalInsight extends Component
{
    public $insightModal;
    public $cardInsight = false;
    public $insight;

    protected $listeners = [
        'carregaInsight'
    ];


    public function carregaInsight(Insights $insight) {
        $this->cardInsight = true;
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

        foreach ($this->insightModal['faturamento']->sk_data as $key => $data){
            $this->insightModal['faturamento']->sk_data[$key] = ucfirst(Carbon::create($data)->monthName);
        }

        foreach ($this->insightModal['chart_um']->sk_data as $key => $data){
            $this->insightModal['chart_um']->sk_data[$key] = ucfirst(Carbon::create($data)->monthName);
        }

        foreach ($this->insightModal['chart_dois']->sk_data as $key => $data){
            $this->insightModal['chart_dois']->sk_data[$key] = ucfirst(Carbon::create($data)->monthName);
        }

        foreach ($this->insightModal['chart_tres']->sk_data as $key => $data){
            $this->insightModal['chart_tres']->sk_data[$key] = ucfirst(Carbon::create($data)->monthName);
        }
        $this->dispatchBrowserEvent(
            'renderDataInsight',
            [
                'faturamento' => $this->insightModal['faturamento'],
                'chart_um' => $this->insightModal['chart_um'],
                'chart_dois' => $this->insightModal['chart_dois'],
                'chart_tres' => $this->insightModal['chart_tres']
            ]
        );
    }

    public function render()
    {
        return view('livewire.components.menus.modal-insight');
    }
}
