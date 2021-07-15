<div >
    <div class="flex flex-col" x-data="{showFiltro: false }">
        <div class="flex">
            <!-- INPUT DE BUSCASE -->
            <div class="flex-1 pr-4">
                <div class="relative md:w-1/3">
                    <input type="search"
                           class="w-full font-bold placeholder-gray-300 border-0 focus:ring focus:border-blue-200 pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"
                           placeholder="Buscar CTRC ou Base..."
                           wire:model.debounce.800ms="buscar">
                    <div class="absolute top-0 left-0 inline-flex items-center p-2">

                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24"
                                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                <circle cx="10" cy="10" r="7" />
                                <line x1="21" y1="21" x2="15" y2="15" />
                            </svg>
                        </div>

                    </div>
                </div>
            </div>

            <!-- FILTROS -->
            <div class="flex flex-col">
                <button @click="showFiltro = !showFiltro" class="bg-white hover:bg-grey text-gray-600 font-bold shadow py-2 px-2 rounded-lg inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    <span>Filtros</span>

                    <svg x-show="showFiltro" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                    </svg>

                    <svg x-show="!showFiltro" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <div  class="flex flex-col bg-white shadow border rounded-md p-3 mt-3"
              x-show="showFiltro"
              x-transition:enter="transform-gpu ease-out duration-300"
              x-transition:enter-start="-translate-y-4 opacity-0"
              x-transition:leave="transform-gpu ease-out duration-200"
              x-transition:leave-end="-translate-y-4 opacity-0"
        >
            <div x-data="{selectPeriodo: ''}" class="flex">
                <select x-model="selectPeriodo" class="font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" name="selectPeriodo" id="selectPeriodo" wire:model.defer="selectPeriodo">
                    <option selected hidden>Periodo</option>
                    <option value="">Todos</option>
                    <option value="0">Por Data</option>
                    <option value="1">Mês</option>
                    <option value="2">Trimestre</option>
                    <option value="3" >Ano</option>
                </select>

                <div class="flex items-center" x-show="selectPeriodo === '1' || selectPeriodo === '2' ||selectPeriodo === '3' ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-7 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <div class="relative h-10 input-component w-32">
                        <select  class="ml-2 font-bold h-full w-full border-gray-300 px-2 transition-all border-blue rounded-md"  name="ano" id="ano" empty wire:model="ano">
                            <option value="">Todos</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                        </select>
                        <label for="address" class="absolute left-4 transition-all bg-white px-1">
                            Address
                        </label>
                    </div>
                </div>


                <div class="flex items-center" x-show="selectPeriodo === '1'">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-7 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <select  class="ml-2 font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="mes" id="mes" wire:model="mes">
                        <option selected hidden>Mês</option>
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
                </div>

                <div class="flex items-center" x-show="selectPeriodo === '0'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-7 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <input type="date" class="ml-2 font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="dataStart" id="dataStart" wire:model="dataStart"/>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-7 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <input type="date" class="ml-2 font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="dataEnd" id="dataEnd" wire:model="dataEnd" />
                </div>
                <div class="flex items-center" x-show="selectPeriodo === '2'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-7 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <select class="ml-2 font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="trimestre" id="trimestre" wire:model="trimestre">
                        <option selected hidden>Trimestre</option>
                        <option value="">Todos</option>
                        <option value="1">Primeiro Trimestre</option>
                        <option value="2">Segundo Trimestre</option>
                        <option value="3">Terceiro Trimestre</option>
                        <option value="4">Quarto Trimestre</option>
                    </select>
                </div>


            </div>

            <div class="mt-3">
                <select class="font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="situacao" id="situacao" wire:model="situacao">
                    <option selected hidden>Situação</option>
                    <option value="">Todos</option>
                    <option value="1">Atrasados</option>
                    <option value="2">Agendados</option>
                </select>

                <select class="ml-2 font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="tipo" id="tipo" wire:model="tipo">
                    <option selected hidden>Tipo</option>
                    <option value="">Todos</option>
                    <option value="INFORMATIVO">Informativo</option>
                    <option value="PENDENCIA">Pendencias</option>
                    <option value="CLIENTE">Cliente</option>
                    <option value="BAIXA">Baixa</option>
                    {{--            <option value="ENTREGA">Entrega</option>--}}
                </select>

                <select class="ml-2 font-bold border-0 focus:ring rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium"  name="processo" id="processo" wire:model="processo">
                    <option selected hidden>Processos</option>
                    <option value="">Todos</option>
                    <option value="OPERACIONAL">Operacional</option>
                    <option value="GERAL">Geral</option>
                    <option value="COLETA">Coleta</option>
                    <option value="ENTREGA">Entrega</option>
                    <option value="FINALIZADOR">Finalizador</option>
                    <option value="REENTREGA">Reentrega</option>
                    <option value="AGENDAMENTO">Agendamento</option>
                    <option value="DEVOLUCAO">Devolução</option>
                    <option value="INDENIZACAO">Indenização</option>
                </select>
            </div>
        </div>

        <!-- TABELA -->
        @if(count($table) > 0)
            <div class="container">
		<table class="w-full flex flex-row  flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
			<thead class="text-white bg-blue-500" wire:loading.class.remove="bg-blue-500" wire:loading.class="bg-blue-200 animate-pulse">
                @foreach ($table as $items)
                    <tr class="bg-teal-400 flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                        @foreach ($items as $key => $item)
                            <th class="p-3 text-left" style="font-size: 11px">{{$key}}</th>
                        @endforeach
                    </tr>
                @endforeach

			</thead>
			<tbody class="flex-1 sm:flex-none">
                @foreach ($table as $items)
                <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                    @foreach ($items as $key => $item)
                        @if ($key == 'Emissao' || $key == 'Ocorrência')
					        <td class="border-grey-light border hover:bg-gray-100 p-2" style="font-size: 10px">{{FormatDateBr($item)}}</td>
                        @elseif($key == 'CTRC')
					        <td class="border-grey-light bg-blue-300 border hover:bg-gray-100 p-2 w-24" style="font-size: 10px">{{$item}}</td>
                        @elseif($key == 'Ult. Atualização')
					        <td class="border-grey-light bg-yellow-200 border text-center hover:bg-gray-100 p-2 w-24" style="font-size: 10px">{{FormatDateBr($item)}}</td>
                        @elseif($key == 'Cidade-Base')
                            <td class="border-grey-light border text-center hover:bg-gray-100 p-2 w-24" style="font-size: 10px">{{$item}}</td>
                        @else
					        <td class="border-grey-light border hover:bg-gray-100 p-2" style="font-size: 10px">{{$item}}</td>
                        @endif
                    @endforeach
				</tr>
                @endforeach
			</tbody>
		</table>
        {{$table->links()}}
	</div>
        @else
            <div class="container flex flex-col mt-36 items-center justify-center text-2xl font-bold text-gray-400" >
                <span>
                       Nenhum dado para ser exibido
               </span>
                <span wire:loading>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-24 w-24" style="margin: auto;  display: block; shape-rendering: auto;" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <circle cx="50" cy="50" fill="none" stroke="#a4a1a1" stroke-width="7" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                          <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </circle>
                    </svg>
                </span>
            </div>
        @endif
    </div>
</div>

<style>
  html,
  body {
    height: 100%;
  }

  @media (min-width: 640px) {
    table {
      display: inline-table !important;
    }

    thead tr:not(:first-child) {
      display: none;
    }
  }

  td:not(:last-child) {
    border-bottom: 0;
  }

  th:not(:last-child) {
    border-bottom: 2px solid rgba(0, 0, 0, .1);
  }
</style>


