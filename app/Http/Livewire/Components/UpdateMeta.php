<?php

namespace App\Http\Livewire\Components;

use App\Models\Meta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UpdateMeta extends Component
{
    public $tipo = "1";
    public $dinheiro;
    public $porcentagem;
    public $metaAtual;

    public function mount(){
        $this->metaAtual = DB::select("select valor from dim_meta WHERE YEAR(referencia) = ".Carbon::today()->year." AND MONTH(referencia) = ".Carbon::today()->month);
        $this->metaAtual = $this->metaAtual[0]->valor;

    }
    public function updateMeta(){
        if($this->tipo == "1"){
            $data = $this->validate([
                'dinheiro' => 'required'
            ],
            [
                'required' => 'O campo :attribute é obrigatório.'
            ],
            [
                'dinheiro' => 'Dinheiro'
            ]
            );
//            DB::select("UPDATE  dim_meta SET valor = ".$data['dinheiro']."WHERE YEAR(referencia) = ".Carbon::today()->year." AND MONTH(referencia) = ".Carbon::today()->month);
        }elseif ($this->tipo == "2") {
            $data = $this->validate([
                'porcentagem' => 'required'
            ],
                [
                    'required' => 'O campo :attribute é obrigatório.'
                ],
                [
                    'porcentagem' => 'Dinheiro'
                ]
            );
//            DB::select("UPDATE  dim_meta SET valor =  ".$data['porcentagem']." WHERE YEAR(referencia) = ".Carbon::today()->year." AND MONTH(referencia) = ".Carbon::today()->month);
        }else{
            dd("Erro ao atualizar");
        }
    }

    public function render()
    {
        return view('livewire.components.update-meta');
    }
}
