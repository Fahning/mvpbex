<x-app-layout>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-4 text-center mt-24">
            <span class="text-gray-500">Atualizar meta de faturamento</span>
            <p class="text-xs text-gray-500">A inserção do faturamento por porcentagem será baseado no mês anterior.</p>
        </div>
        <div class="col-span-8">
            @livewire('components.update-meta')
        </div>
    </div>
    <div class="m-10 mx-2"><hr></div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-4 text-center mt-24">
            <span class="text-gray-500">Definir meta de faturamento para o próximo mês</span>
            <p class="text-xs text-gray-500">A inserção do faturamento por porcentagem será baseado no mês anterior.</p>
        </div>
        <div class="col-span-8">
            @livewire('components.new-meta')
        </div>
    </div>

</x-app-layout>
