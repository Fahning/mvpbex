<?php

namespace App\Http\Livewire\Components;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class NewMeta extends Component
{
    use Actions;

    public $dinheiro;
    public $porcentagem;
    public $newMeta;

    public function mount(){
        $this->newMeta = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->addMonth()->month);
        if(!empty($this->newMeta)){
            $this->newMeta = $this->newMeta[0]->META;
        }
    }
    public function newMeta(){
        if(!is_null($this->dinheiro) && is_null($this->porcentagem)){
            DB::select("INSERT INTO dim_meta VALUES(YEAR(CURRENT_DATE() + INTERVAL 1 MONTH), MONTH(CURRENT_DATE() + INTERVAL 1 MONTH), {$this->dinheiro}, 0, 0, 0, 0)");
            $this->newMeta = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->addMonth()->month);
            $this->newMeta = $this->newMeta[0]->META;
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
            DB::select("INSERT INTO dim_meta VALUES(YEAR(CURRENT_DATE() + INTERVAL 1 MONTH), MONTH(CURRENT_DATE() + INTERVAL 1 MONTH), (SELECT {$value}*SUM(val_frete) FROM tabela_ctes WHERE ano = YEAR(CURRENT_DATE()) AND mes = MONTH(CURRENT_DATE())-1), 0, 0, 0, 0);");
            $this->newMeta = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->addMonth()->month);
            $this->newMeta = $this->newMeta[0]->META;
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
        return view('livewire.components.new-meta');
    }
}
