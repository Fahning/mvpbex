<?php

namespace App\Http\Livewire\Components\Insights\Modal;

use App\Models\Insight;
use Livewire\Component;

class ChartFaturamento extends Component
{
    public $insightModal = [];
    public $insight_id;

    public function render()
    {

        return view('livewire.components.insights.modal.chart-faturamento');
    }
}
