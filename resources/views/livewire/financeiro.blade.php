<x-app-layout>
{{--    Remover component desse filtro ante\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\--}}
    <div class="p-2">
        <p class="text-2xl font-bold text-center">
            FAROL DE FATURAMENTO
        </p>
        <hr class="border-2 rounded-md">

    </div>
    <div class="grid grid-cols-9 mb-6">
        <div class="col-span-1">
            @livewire('components.farol')
        </div>
        <div class="col-span-8">
            @livewire('components.indicadores')
        </div>
        <div class="col-span-9 mt-6">
            @livewire('components.farol-faturamento.chart-faturamento')
        </div>
        <div class="col-span-9 my-3">
            @livewire('components.farol-faturamento.chart-realizado-orcado')
        </div>
        <div class="col-span-9 my-3">
            @livewire('components.farol-faturamento.table-evolucao-desvios')
        </div>
    </div>

    <div class="p-2">
        <p class="text-2xl font-bold text-center">
            ANÁLISE DO SEGMENTO
        </p>
        <hr class="border-2 rounded-md">
    </div>
    <div class="grid grid-cols-9 mb-6">
        <div class="col-span-9 my-3">
            @livewire('components.analise-segmento.chart-segmento')
        </div>

        <div class="col-span-9 my-3">
            @livewire('components.analise-segmento.table-rpk-segmento')
        </div>

        <div class="col-span-9 my-3">
            @livewire('components.analise-segmento.table-meta-segmento')
        </div>
    </div>

    <div class="p-2">
        <p class="text-2xl font-bold text-center">
            ANÁLISE DOS CLIENTES
        </p>
        <hr class="border-2 rounded-md">
    </div>
    <div class="grid grid-cols-9 mb-6">
        <div class="col-span-9 my-3">
            @livewire('components.analise-clientes.chart-clientes')
        </div>

        <div class="col-span-9 my-3">
            @livewire('components.analise-clientes.table-rpk-clientes')
        </div>

        <div class="col-span-9 my-3">
            @livewire('components.analise-clientes.table-meta-clientes')
        </div>

        <div class="col-span-9 my-3">
            @livewire('components.analise-clientes.tabela-distribuicao')
        </div>
    </div>

    <div class="p-2">
        <p class="text-2xl font-bold text-center">
            ANÁLISE DAS BASES
        </p>
        <hr class="border-2 rounded-md">
    </div>

    <div class="grid grid-cols-9 mb-6">
        <div class="col-span-9 my-3">
            @livewire('components.analise-bases.chart-bases')
        </div>
        <div class="col-span-9 my-3">
            @livewire('components.analise-bases.table-rpk-bases')
        </div>
        <div class="col-span-9 my-3">
            @livewire('components.analise-bases.table-meta-bases')
        </div>
        <div class="col-span-9 my-3">
            @livewire('components.analise-bases.table-rota-transferencia')
        </div>
        <div class="col-span-9 my-3">
            @livewire('components.analise-bases.table-rota-entrega')
        </div>
    </div>
</x-app-layout>
