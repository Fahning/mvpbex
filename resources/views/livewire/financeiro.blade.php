<x-app-layout>
    @livewire('components.filters-buttom')

{{--    <div class="p-2">--}}
{{--        <p class="text-2xl font-bold">--}}
{{--            FAROL DE FATURAMENTO--}}
{{--        </p>--}}
{{--        <hr class="border-2 rounded-md">--}}
{{--    </div>--}}
{{--    <div class="grid grid-cols-9 px-6 mb-6">--}}
{{--        <div class="col-span-1">--}}
{{--            @livewire('components.farol')--}}
{{--        </div>--}}
{{--        <div class="col-span-8">--}}
{{--            @livewire('components.indicadores')--}}
{{--        </div>--}}
{{--        <div class="col-span-9 mt-6">--}}
{{--            @livewire('components.farol-faturamento.chart-faturamento')--}}
{{--        </div>--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.farol-faturamento.chart-realizado-orcado')--}}
{{--        </div>--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.farol-faturamento.table-evolucao-desvios')--}}
{{--        </div>--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.farol-faturamento.table-year-of-year')--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="p-2">
        <p class="text-2xl font-bold">
            ANÁLISE DO SEGMENTO
        </p>
        <hr class="border-2 rounded-md">
    </div>
{{--    <div class="grid grid-cols-9 px-6 mb-6">--}}
        <div class="col-span-9 my-3">
            @livewire('components.analise-segmento.chart-segmento')
        </div>

{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.analise-segmento.table-rpk')--}}
{{--        </div>--}}

{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.analise-segmento.table-meta')--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="p-2">--}}
{{--        <p class="text-2xl font-bold">--}}
{{--            ANÁLISE DOS CLIENTES--}}
{{--        </p>--}}
{{--        <hr class="border-2 rounded-md">--}}
{{--    </div>--}}
{{--    <div class="grid grid-cols-9 px-6 mb-6">--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.chart-clientes')--}}
{{--        </div>--}}

{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.table-rpk-clientes')--}}
{{--        </div>--}}

{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.table-meta-clientes')--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="p-2">--}}
{{--        <p class="text-2xl font-bold">--}}
{{--            ANÁLISE DAS BASES--}}
{{--        </p>--}}
{{--        <hr class="border-2 rounded-md">--}}
{{--    </div>--}}
{{--    <div class="grid grid-cols-9 px-6 mb-6">--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.chart-bases')--}}
{{--        </div>--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.table-rpk-bases')--}}
{{--        </div>--}}
{{--        <div class="col-span-9 my-3">--}}
{{--            @livewire('components.table-meta-bases')--}}
{{--        </div>--}}
{{--    </div>--}}
</x-app-layout>
