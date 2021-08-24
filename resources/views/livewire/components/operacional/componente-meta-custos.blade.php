<div>
    <x-notifications />
    <div>
        <div class="flex items-end mt-4 w-full">
            <div class="flex-1 w-full">
                <x-select
                    label="Selecione a operação a ser alterada"
                    placeholder="Selecione um tipo de custo"
                    searchable=false
                    :options="[
                        ['name' => 'Coleta',  'id' => 'META_COLETA'],
                        ['name' => 'Entrega', 'id' => 'META_ENTREGA'],
                        ['name' => 'Transferencia', 'id' => 'META_TRANSFERENCIA'],
                    ]"
                    option-label="name"
                    option-value="id"
                    wire:model="tipoCusto"
                />
            </div>
            <div wire:loading class="h-10 w-10 ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="#a7a7a7" stroke-width="15" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"/>
                    </circle>
                </svg>
            </div>
        </div>
        <div class="m-5 mx-2"><hr></div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 text-center mt-14">
                <span class="text-gray-500">Atualizar meta de custo</span>
            </div>
            <div class="col-span-8">
                <div class="mt-6  border  shadow-md rounded-md p-4 bg-white mx-8 ">
                    <div class="flex justify-center">
                        <div class="grid grid-cols-1 gap-4 w-2/3">
                            <div class="text-center font-bold text-4xl ">
                                {{formatPorcent($metaAtual)}} %
                            </div>
                            <div class="text-md text-center font-serif  font-bold">
                                Meta de Custo do Mês Atual
                            </div>
                        </div>
                    </div>
                    <div class="w-full"
                        x-data
                        x-init="IMask(document.getElementById('newMetaThisMonth'), {
                        mask: '00.00'
                        });"
                    >
                        <x-input
                            id="newMetaThisMonth"
                            label="Porcentagem" placeholder="Exemplo: 03.5"
                            wire:model.defer="newMetaThisMonth"
                            emitFormatted
                        >
                            <x-slot name="append">
                                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                                    <x-button
                                        label="Definir Meta"
                                        wire:click.prevent="updateMeta"
                                        spinner="updateMeta"
                                        class="rounded-r-md h-full bg-gray-100"
                                        info
                                        flat
                                        squared
                                    />
                                </div>
                            </x-slot>
                        </x-input>
                    </div>
                    <div class="text-center text-red-600 mt-2">
                        @error('dinheiro') <span>{{ $message }}</span> @enderror
                        @error('porcentagem') <span>{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="m-5 mx-2"><hr></div>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-4 text-center mt-14">
                <span class="text-gray-500">Definir meta de custo para o próximo mês</span>
            </div>
            <div class="col-span-8">
                <div class="mt-6  border  shadow-md rounded-md p-4 bg-white mx-8 " >
                    <div class="flex justify-center">
                        <div class="grid grid-cols-1 gap-4 w-2/3">
                            <div class="text-center font-bold text-4xl ">
                                {{formatPorcent($MetaProximoMes)}} %
                            </div>
                            <div class="text-md text-center font-serif  font-bold">
                                Meta de Custo do Próximo Mês
                            </div>
                        </div>
                    </div>
                    <div
                        class="w-full"
                        x-data
                        x-init="IMask(document.getElementById('newMetaNextMonth'), {
                        mask: '00.00'
                        });"
                    >
                        <x-input
                            id="newMetaNextMonth"
                            label="Porcentagem" placeholder="Exemplo: 03.5"
                            wire:model.defer="newMetaNextMonth"
                            emitFormatted
                        >
                            <x-slot name="append">
                                <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                                    <x-button
                                        label="Definir Meta"
                                        wire:click.prevent="newMeta"
                                        spinner="newMeta"
                                        class="rounded-r-md h-full bg-gray-100"
                                        info
                                        flat
                                        squared
                                    />
                                </div>
                            </x-slot>
                        </x-input>
                    </div>

                    <div class="text-center text-red-600 mt-2">
                        @error('dinheiro') <span>{{ $message }}</span> @enderror
                        @error('porcentagem') <span>{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
