<x-app-layout>
    <div class="my-3">
        @livewire('components.movimentacoes.filtro-movimentacoes')
    </div>
    <div class="my-3">
        <livewire:components.movimentacoes.tabela-over-views title="Painel Geral de Movimentações"/>
    </div>
    <div class="my-3">
        <livewire:components.movimentacoes.tabelachegadas title="Chegadas-Transferência"/>
    </div>
    <div class="my-3">
        <livewire:components.movimentacoes.tabelasaidas  title="Saídas-Transferência"/>
    </div>
    <div class="my-3">
        <livewire:components.movimentacoes.tabela-saida-entrega  title="Saídas-Entrega"/>
    </div>
    <div class="my-3">
        <livewire:components.movimentacoes.tabela-agendamentos  title="Entregas-Agendadas"/>
    </div>
    <div class="my-3">
        @livewire('components.movimentacoes.grafico-rota-transferencia')
    </div>
    <div class="my-3">
        @livewire('components.movimentacoes.grafico-rota-entrega')
    </div>
    <div class="my-3">
        @livewire('components.movimentacoes.grafico-status-entrega')
    </div>
</x-app-layout>

