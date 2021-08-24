<?php

namespace App\Http\Livewire\Components\Operacional;

use App\Models\DimMeta;
use Carbon\Carbon;
use Livewire\Component;
use WireUi\Traits\Actions;

class ComponenteMetaCustos extends Component
{
    use Actions;
    public $tipoCusto = 'META_COLETA';
    public $newMetaThisMonth;
    public $newMetaNextMonth;
    public $metaAtual;
    public $MetaProximoMes;


    public function updateMeta()
    {
        if(!is_null($this->newMetaThisMonth)){
            DimMeta::where('ANO', Carbon::today()->year)
            ->where('MES', Carbon::today()->month)
            ->update([
                $this->tipoCusto => $this->newMetaThisMonth
            ]);
            $this->notification()->notify([
                'title'       => 'Sucesso',
                'description' => 'Meta atualizada com sucesso',
                'icon'        => 'success',
                'iconColor'   => 'green',
                'timeout'     => 2000

            ]);
            $this->metaAtual = $this->newMetaThisMonth;

        }else{
            $this->notification()->notify([
                'title'       => 'Erro',
                'description' => 'Informe um valor em porcentagem',
                'icon'        => 'error',
                'iconColor'   => 'red',
                'timeout'     => 2000

            ]);
            $this->newMetaThisMonth = 0;
        }
    }

    public function newMeta()
    {
        if(!is_null($this->newMetaNextMonth)){
            DimMeta::where('ANO', Carbon::today()->addMonth()->year)
                ->where('MES', Carbon::today()->addMonth()->month)
                ->update([
                    $this->tipoCusto => $this->newMetaNextMonth
                ]);
            $this->notification()->notify([
                'title'       => 'Sucesso',
                'description' => 'Meta definida com sucesso',
                'icon'        => 'success',
                'iconColor'   => 'green',
                'timeout'     => 2000

            ]);
            $this->MetaProximoMes = $this->newMetaNextMonth;

        }else{
            $this->notification()->notify([
                'title'       => 'Erro',
                'description' => 'Informe um valor em porcentagem',
                'icon'        => 'error',
                'iconColor'   => 'red',
                'timeout'     => 2000

            ]);
            $this->newMetaNextMonth = 0;
        }
    }

    public function render()
    {
        $this->metaAtual = DimMeta::select($this->tipoCusto)
            ->where('ANO', Carbon::today()->year)
            ->where('MES', Carbon::today()->month)
            ->first()->toArray()[$this->tipoCusto];

        $this->MetaProximoMes = DimMeta::select($this->tipoCusto)
            ->where('ANO', Carbon::today()->addMonth()->year)
            ->where('MES', Carbon::today()->addMonth()->month)
            ->first()->toArray()[$this->tipoCusto];
        return view('livewire.components.operacional.componente-meta-custos');
    }
}
