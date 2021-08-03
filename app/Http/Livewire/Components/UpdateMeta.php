<?php

namespace App\Http\Livewire\Components;

use App\Models\Meta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class UpdateMeta extends Component
{
    use Actions;

    public $dinheiro;
    public $porcentagem;
    public $metaAtual;

    public function mount(){
        $this->metaAtual = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->month);
        $this->metaAtual = $this->metaAtual[0]->META;

    }
    public function updateMeta(){

        if(!is_null($this->dinheiro) && is_null($this->porcentagem)){
            DB::select("UPDATE dim_meta SET META = {$this->dinheiro} WHERE ANO = YEAR(CURRENT_DATE()) AND MES = MONTH(CURRENT_DATE())");
            $this->metaAtual = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->month);
            $this->metaAtual = $this->metaAtual[0]->META;
            $this->dinheiro = null;
            $this->porcentagem = null;
            $this->notification()->notify([
                'title'       => 'Sucesso',
                'description' => 'Meta definida com sucesso',
                'icon'        => 'success',
                'iconColor'   => 'green',
                'timeout'     => 2000

            ]);
        }elseif (!is_null($this->porcentagem) && is_null($this->dinheiro)) {
            $value = floatval($this->porcentagem) / 100 + 1;
            DB::select("UPDATE dim_meta
                SET META = (SELECT {$value} * SUM(val_frete) FROM tabela_ctes WHERE ano = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) AND mes = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH))
                WHERE ANO = YEAR(CURRENT_DATE()) AND MES = MONTH(CURRENT_DATE())");
            $this->metaAtual = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->month);
            $this->metaAtual = $this->metaAtual[0]->META;
            $this->dinheiro =  null;
            $this->porcentagem = null;
            $this->notification()->notify([
                'title'       => 'Sucesso',
                'description' => 'Meta definida com sucesso',
                'icon'        => 'success',
                'iconColor'   => 'green',
                'timeout'     => 2000

            ]);
        }else{
            $this->notification()->notify([
                'title'       => 'Erro',
                'description' => 'Informe somente um valor',
                'icon'        => 'error',
                'iconColor'   => 'red',
                'timeout'     => 2000

            ]);
            $this->dinheiro =  null;
            $this->porcentagem = null;
        }
    }

    public function render()
    {
        return view('livewire.components.update-meta');
    }
}
