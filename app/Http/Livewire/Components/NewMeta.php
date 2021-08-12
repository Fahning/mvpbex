<?php

namespace App\Http\Livewire\Components;

use App\Models\DimMeta;
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
    protected $value;

    public function mount(){
        $this->newMeta = DB::select("select META from dim_meta WHERE ANO = ".Carbon::today()->year." AND MES = ".Carbon::today()->addMonth()->month);
        if(!empty($this->newMeta)){
            $this->newMeta = $this->newMeta[0]->META;
        }
    }
    public function newMeta(){
        if(!is_null($this->dinheiro) && is_null($this->porcentagem)){
            $this->value = $this->dinheiro;
        }elseif (!is_null($this->porcentagem) && is_null($this->dinheiro)) {
            $this->newMeta = DB::table('tabela_ctes')
                ->select(DB::raw('SUM(val_frete) as fat'))
                ->where('ano', Carbon::today()->subMonth()->year)
                ->where('mes', Carbon::today()->subMonth()->month)
                ->first();
            $this->value = (floatval($this->porcentagem) / 100 + 1) * floatval($this->newMeta->fat) ;
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

        $retorno = DB::table('dim_meta')
            ->updateOrInsert([
                'ANO'   => Carbon::today()->addMonth()->year,
                'MES'   => Carbon::today()->addMonth()->month,
            ],
            [
                'META'  => $this->value
            ]
        );
        if($retorno){
            $this->newMeta = $this->value;
            $this->dinheiro = null;
            $this->porcentagem = null;
        }
        $this->notification()->notify([
            'title'       => 'Sucesso',
            'description' => 'Meta definida com sucesso',
            'icon'        => 'success',
            'iconColor'   => 'green',
            'timeout'     => 2000

        ]);
    }
    public function render()
    {
        return view('livewire.components.new-meta');
    }
}
