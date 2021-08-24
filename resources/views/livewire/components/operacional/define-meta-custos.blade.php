<x-app-layout>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-4 text-center mt-24">
            <span class="text-gray-500">Atualizar meta de faturamento</span>
            <p class="text-xs text-gray-500">A inserção do faturamento por porcentagem será baseado no mês anterior.</p>
        </div>
        <div class="col-span-8">
            <div class="mt-6  border  shadow-md rounded-md p-4 bg-white mx-8 ">
                <div class="flex justify-center">
                    <div class="grid grid-cols-1 gap-4 w-2/3">
                        <div class="text-center font-bold text-4xl ">
{{--                            {{formatReceita($metaAtual)}}--}}
                        </div>
                        <div class="text-md text-center font-serif  font-bold">
                            Meta de Faturamento do Mês Atual
                        </div>
                    </div>
                </div>
                <div class="flex justify-center w-full mt-6">
{{--                    <form method="post" wire:submit.prevent="updateMeta" class="flex items-end">--}}

{{--                        <x-inputs.currency--}}
{{--                            icon="cash"--}}
{{--                            label="Dinheiro"--}}
{{--                            placeholder="Informe o valor em Reais"--}}
{{--                            thousands="."--}}
{{--                            decimal=","--}}
{{--                            precision="2"--}}
{{--                            wire:model.defer="dinheiro"--}}
{{--                        />--}}
{{--                        <div class="mx-2">OU</div>--}}
{{--                        <x-inputs.maskable--}}
{{--                            placeholder="Exemplo: 03.5"--}}
{{--                            label="Porcentagem"--}}
{{--                            suffix="%"--}}
{{--                            mask="##.##"--}}
{{--                            wire:model.defer="porcentagem"--}}
{{--                            emitFormatted--}}
{{--                        ></x-inputs.maskable>--}}

{{--                        <x-button-p class="mx-2 border border-gray-400 rounded-md p-1 hover:bg-gray-500 h-10" >Definir Meta</x-button-p>--}}
{{--                    </form>--}}
                </div>
                <div class="text-center text-red-600 mt-2">
                    @error('dinheiro') <span>{{ $message }}</span> @enderror
                    @error('porcentagem') <span>{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="m-10 mx-2"><hr></div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-4 text-center mt-24">
            <span class="text-gray-500">Definir meta de faturamento para o próximo mês</span>
            <p class="text-xs text-gray-500">A inserção do faturamento por porcentagem será baseado no mês anterior.</p>
        </div>
        <div class="col-span-8">
            <div class="mt-6  border  shadow-md rounded-md p-4 bg-white mx-8 ">
                <x-notifications />
                <div class="flex justify-center">
                    <div class="grid grid-cols-1 gap-4 w-2/3">
                        <div class="text-center font-bold text-4xl ">
{{--                            {{formatReceita($newMeta)}}--}}
                        </div>
                        <div class="text-md text-center font-serif  font-bold">
                            Meta de Faturamento do Próximo Mês
                        </div>
                    </div>
                </div>
                <div class="flex justify-center w-full mt-6">
{{--                    <form method="post" wire:submit.prevent="newMeta" class="flex items-end">--}}
{{--                        <x-inputs.currency--}}
{{--                            icon="cash"--}}
{{--                            label="Dinheiro"--}}
{{--                            placeholder="Informe o valor em Reais"--}}
{{--                            thousands="."--}}
{{--                            decimal=","--}}
{{--                            precision="2"--}}
{{--                            wire:model.defer="dinheiro"--}}
{{--                        />--}}
{{--                        <div class="mx-2">OU</div>--}}
{{--                        <x-inputs.maskable--}}
{{--                            placeholder="Exemplo: 3,5"--}}
{{--                            label="Porcentagem"--}}
{{--                            suffix="%"--}}
{{--                            mask="##.##"--}}
{{--                            wire:model.defer="porcentagem"--}}
{{--                            emitFormatted--}}
{{--                        ></x-inputs.maskable>--}}

{{--                        <x-button-p class="mx-2 border border-gray-400 rounded-md p-1 hover:bg-gray-500 h-10" >Definir Meta</x-button-p>--}}
{{--                    </form>--}}
                </div>
                <div class="text-center text-red-600 mt-2">
                    @error('dinheiro') <span>{{ $message }}</span> @enderror
                    @error('porcentagem') <span>{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
