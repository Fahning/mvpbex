<?php

namespace App\Http\Livewire\Components\Movimentacoes;

use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FiltroMovimentacoes extends Component
{
    public $cidades = [];
    public $bases = [];
    public $selectedCidade;
    public $selectedBase;
    public $showSelectBase = true;
    public $query= '';
    public array $accounts = [];
    public $selectedAccount;
    public int $highlightIndex = 0;
    public bool $showDropdownAuto;


    public function mount()
    {
        $this->reset();
        $cidades = DB::table('bexsal_bdsal.relacao_unidade_local')
            ->select('cidade')
            ->distinct()
            ->get();
        foreach($cidades as $cidade){
            array_push($this->cidades, $cidade->cidade);
        }
    }

    public function reset(...$properties)
    {
        $this->accounts = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedAccount = null;
        $this->showDropdownAuto = true;
    }

    public function hideDropdown()
    {
        $this->showDropdownAuto = false;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->accounts) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->accounts) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function selectAccount($id = null)
    {
        $id = $id ?: $this->highlightIndex;

        $account = $this->accounts[$id] ?? null;

        if ($account) {
            $this->showDropdownAuto = false;
            $this->query = $account['cliente'];
            $this->selectedAccount = $account['cliente'];
        }
    }

    public function updatedQuery()
    {
        $this->accounts = Cliente::where('cliente', 'like', '%' . $this->query. '%')
            ->take(5)
            ->get()
            ->toArray();
    }

    public function render()
    {
        if(!is_null($this->selectedCidade)){
            $this->bases = [];
            $bases = DB::table('bexsal_bdsal.relacao_unidade_local')
                ->select('sigla')
                ->where('cidade', $this->selectedCidade)
                ->get();
            foreach($bases as $base){
                array_push($this->bases, $base->sigla);
            }
            $this->showSelectBase = true;
        }else{
            $this->selectedBase = null;
            $this->showSelectBase = false;
        }

        if(!is_null($this->selectedCidade) || !is_null($this->selectedBase) || !is_null($this->selectedAccount)){
            $this->emit('filtroMovimentacoes', [$this->selectedCidade, $this->selectedBase, $this->selectedAccount]);
        }
        return view('livewire.components.movimentacoes.filtro-movimentacoes');
    }
}
