<x-app-layout>
    <div class="p-2">
        <p class="text-xl font-bold">
            Análise de Custos
        </p>
        <hr class="border-2 rounded-md">
        <div class="my-5">
            @livewire('components.operacional.analise-de-custos.cards')
        </div>
        <div class="my-5">
            @livewire('components.operacional.analise-de-custos.grafico-custos')
        </div>
{{--        <div class="my-5">--}}
{{--            @livewire('components.operacional.analise-de-custos.table-custos')--}}
{{--        </div>--}}
        <div class="my-5">
            @livewire('components.operacional.analise-de-custos.table-placas')
        </div>
    </div>
</x-app-layout>
