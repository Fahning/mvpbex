<div x-data>
    <div class="flex items-center mt-4 w-full"
         x-transition
    >
        <div class="flex flex-col flex-1">
            <div class="flex">
                <div class="flex-1 w-full">
                    <x-select
                        label="Selecionar Cidade"
                        placeholder="Selecione uma cidade"
                        :options="$cidades"
                        wire:model="selectedCidade"
                    />
                </div>

                <div x-show="$wire.showSelectBase" class="flex-1 w-full pl-5"
                     x-transition
                >
                    <x-select
                        label="Selecionar Base"
                        multiselect
                        placeholder="Selecione uma base"
                        :options="$bases"
                        wire:model="selectedBase"
                    />
                </div>
            </div>

            <div class="relative mt-4">
                <div class="relative">
                    <x-input
                        type="text"
                        label="Selecionar Cliente"
                        placeholder="Buscar Clientes"
                        wire:model.debounce.1000ms="query"
                        wire:click="reset"
                        wire:keydown.escape="hideDropdown"
                        wire:keydown.tab="hideDropdown"
                        wire:keydown.Arrow-Up="decrementHighlight"
                        wire:keydown.Arrow-Down="incrementHighlight"
                        wire:keydown.enter.prevent="selectAccount"
                    />

                    <input type="hidden" name="account" id="account" wire:model="selectedAccountID">

                    @if ($selectedAccount)
                        <a class="absolute cursor-pointer top-8 right-2 text-gray-500" wire:click="reset">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    @endif
                </div>

                @if(!empty($query) && $selectedAccount == 0 && $showDropdownAuto)
                    <div class="absolute z-10 bg-white mt-1 w-full border border-gray-300 rounded-md shadow-lg">
                        @if (!empty($accounts))
                            @foreach($accounts as $i => $account)
                                <a
                                    wire:click="selectAccount({{ $i }})"
                                    class="block py-1 px-2 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndex === $i ? 'bg-blue-50' : '' }}"
                                >{{ $account['cliente'] }}</a>
                            @endforeach
                        @else
                            <span class="block py-1 px-2 text-sm">Nenhum cliente encontrado!</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div wire:loading class="h-10 w-10 ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="50" cy="50" fill="none" stroke="#a7a7a7" stroke-width="15" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                    <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"/>
                </circle>
            </svg>
        </div>
    </div>

</div>
