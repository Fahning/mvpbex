<?php

namespace App\Http\Livewire\Components\Menus;

use App\Models\Insight;
use App\Models\Insights;
use Livewire\Component;

class ModalInsight extends Component
{
    public $insight;
    public $insightModal;

    protected $listeners = ['mostraModal'];

    public function mostraModal(Insights $insight) {
        $ins = Insight::find($insight->insight_id);
        if(!empty($ins)){
            $this->insightModal = [
                'descricao' => $insight->descricao,
                'faturamento' => json_decode($ins->faturamento_ultimos_tres_meses),
                'chart_um' => json_decode($ins->chart_um),
                'chart_dois' => json_decode($ins->chart_dois),
                'chart_tres' => json_decode($ins->chart_tres)
            ];
        }
        $this->dispatchBrowserEvent('abreModal', ['abreModal' => true]);
    }
    public function render()
    {
        return view('livewire.components.menus.modal-insight');
    }
}
