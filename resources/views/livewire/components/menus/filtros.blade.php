<div>
    <div
        class="fixed z-10 inset-0 bg-black bg-opacity-50"
        @click="isSettingsPanelOpen = false"
        aria-hidden="true"
    ></div>

    <!-- Panel -->
    <section
        x-show="isSettingsPanelOpen"
        x-transition:enter="transform transition-transform duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition-transform duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 z-20 right-0 w-64 bg-white border-l border-indigo-100 rounded-l-3xl"
    >
        <div class="px-4 py-8" >
                <div x-data="{selectPeriodo: null}">
                    <div class="flex justify-between">
                        <div class="text-lg font-semibold">Filtros</div>
                        <x-button wire:click="resetFilters" @click="selectPeriodo = null" xs icon="x" spinner="resetFilters"  outline  class="mb-1" label="Limpar"/>
                    </div>
                    <hr class="py-2">
                    <!--filtros-->
                    <div class="flex flex-col" style="height: 76vh">
                        <div  class="flex-1 overflow-y-auto px-1" >
                            <div>
                                <div class="text-sm text-gray-500">Filtros Globais</div>
                                <hr>
                            </div>
                            <!-- Periodos -->
                            <div class="relative h-10 my-5 input-component ">
                                <select x-model="selectPeriodo" class="font-bold h-full w-full border-gray-300 px-2 empty transition-all border-blue rounded-lg"  >
                                    <option hidden selected value="">Selecionar Período</option>
                                    {{--    <option value="0">Por Data</option>     --}}
                                    {{--    <option value="2">Trimestre</option>    --}}
                                    {{--    <option value="3" >Ano</option>         --}}
                                    <option value="1">Mês</option>
                                </select>
                                <label class="absolute left-4 transition-all bg-white px-1">
                                    Período
                                </label>
                            </div>

                            <div x-show="selectPeriodo"
                                 x-transition:enter="transform-gpu ease-out duration-300"
                                 x-transition:enter-start="-translate-y-4 opacity-0"
                                 x-transition:leave="transform-gpu ease-out duration-200"
                                 x-transition:leave-end="-translate-y-4 opacity-0"
                                 class="bg-blue-100 rounded-lg p-2 mt-1 pt-4">
                                <div class="flex flex-col w-full" x-show="selectPeriodo === '0'">
                                    <div class="relative h-10 w-full input-component">
                                        <input
                                            type="date"
                                            id="dataStart"
                                            name="dataStart"
                                            wire:model.defer="filtros.dataStart"
                                            class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-lg"
                                        />
                                        <label for="dataStart" class="absolute left-2 transition-all bg-white rounded-t-md px-1">
                                            Data Inicial
                                        </label>
                                    </div>
                                    <div class="relative h-10 mt-4 w-full input-component">
                                        <input
                                            type="date"
                                            id="dataEnd"
                                            name="dataEnd"
                                            wire:model.defer="filtros.dataEnd"
                                            class="h-full w-full border-gray-300 px-2 transition-all border-blue rounded-lg"
                                        />
                                        <label for="dataEnd" class="absolute left-2 transition-all bg-white rounded-t-md px-1">
                                            Data Final
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center w-full" x-show="selectPeriodo === '1' || selectPeriodo === '2' ||selectPeriodo === '3' ">
                                    <div class="relative h-10 input-component w-full">
                                        <select class="font-bold h-full w-full border-gray-300 px-2 transition-all border-blue rounded-md"  name="ano" id="ano" wire:model.defer="filtros.ano">
                                            <option value="">Todos</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                        </select>
                                        <label for="address" class="absolute left-4 transition-all bg-white rounded-t-md px-1">
                                            Ano
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center w-full mt-4" x-show="selectPeriodo === '1'">
                                    <div class="relative h-10 input-component w-full">
                                        <select class="font-bold h-full w-full border-gray-300 px-2 transition-all border-blue rounded-lg" wire:model.defer="filtros.mes"  >
                                            <option value="">Todos</option>
                                            <option value="1">Janeiro</option>
                                            <option value="2">Fevereiro</option>
                                            <option value="3">Março</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Maio</option>
                                            <option value="6">Junho</option>
                                            <option value="7">Julho</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Setembro</option>
                                            <option value="10">Outubro</option>
                                            <option value="11">Novembro</option>
                                            <option value="12">Dezembro</option>
                                        </select>
                                        <label class="absolute left-4 transition-all bg-white rounded-t-md px-1">
                                            Mês
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center w-full mt-4" x-show="selectPeriodo === '2'">
                                    <div class="relative h-10 w-full input-component ">
                                        <select class="font-bold h-full w-full border-gray-300 px-2 transition-all border-blue rounded-lg" wire:model.defer="filtros.trimestre"  >
                                            <option value="">Todos</option>
                                            <option value="1">Primeiro Trimestre</option>
                                            <option value="2">Segundo Trimestre</option>
                                            <option value="3">Terceiro Trimestre</option>
                                            <option value="4">Quarto Trimestre</option>
                                        </select>
                                        <label class="absolute left-4 transition-all bg-white rounded-t-md px-1">
                                            Trimestre
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="my-5">
                                <x-select
                                    placeholder="Ordenar Desvios"
                                    :options="[
                                                ['name' => 'Maiores Desvios',  'id' => 'desc'],
                                                ['name' => 'Menores Desvios', 'id' => 'asc'],
                                            ]"
                                    option-label="name"
                                    option-value="id"
                                    wire:model.defer="filtros.orderDesvios"
                                />
                            </div>
                            <!-- /Periodos -->
                            <!-- ANALISE DE CLIENTES -->
                            <div class="m-1">
                                <div class="text-sm text-gray-500">Filtros Analise de Clientes</div>
                                <hr>
                            </div>
                            <div x-data="{isTyped: false}">
                                <div>
                                    <div class="relative">
                                        <x-input type="text"
                                               placeholder="{{__('Buscar Cliente')}}"
                                               x-on:input.debounce.400ms="isTyped = ($event.target.value != '')"
                                               autocomplete="off"
                                               wire:model.debounce.500ms="search"
                                               aria-label="Buscar Cliente" />
                                    </div>
                                    {{-- search box --}}
                                    <div x-show="isTyped" x-cloak>
                                        <div>
                                            <div class="fixed bg-white rounded-md shadow border z-20 w-52">
                                                @forelse($articles as $article)
                                                    <div>
                                                        <ul>
                                                            <li class="cursor-pointer hover:bg-blue-500" x-on:click="isTyped = false">
                                                                <a wire:click="changeSearch('{{$article->nome_pagador}}')">
                                                                    {{$article->nome_pagador}}
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @empty
                                                    <div x-cloak>
                                                        {{$isEmpty}}
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- ANALISE DE BASES -->
                            <div class="m-1">
                                <div class="text-sm text-gray-500 text-upper">Filtros Analise de Bases</div>
                                <hr>
                            </div>
                            <div class="mb-7">
                                <x-select
                                    placeholder="Selecionar Bases"
                                    multiselect
                                    :options="$listBases"
                                    wire:model.defer="filtros.searchBase"
                                />
                            </div>
                            <!-- ANALISE DE SEGMENTOS -->
                            <div class="m-1">
                                <div class="text-sm text-gray-500 text-uppercase">Filtros Analise de Segmentos</div>
                                <hr>
                            </div>
                            <div class="mb-7">
                                <x-select
                                    placeholder="Selecionar Segmentos"
                                    multiselect
                                    :options="$segmentolist"
                                    wire:model.defer="filtros.searchSegmentos"></x-select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="py-1">
                <x-button
                    class="w-full"
                    @click="isSettingsPanelOpen = false"
                    lg
                    primary
                    spinner="filtrar"
                    wire:click="filtrar"
                    label="Filtrar">
                </x-button>

        </div>
    </section>

</div>
