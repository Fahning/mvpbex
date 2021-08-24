<div class="bg-white shadow-md pb-4 px-4 rounded-md w-full">
    @if($tipoTable == 'cb.placa')
        <div class="text-center font-bold pt-3">Custos por Veículo</div>
    @elseif($tipoTable == 'cb.unidade')
        <div class="text-center font-bold pt-3">Custos por Unidade</div>
    @elseif($tipoTable == 'cb.set_')
        <div class="text-center font-bold pt-3">Custos por Rota</div>
    @elseif($tipoTable == 'veic.RELACIONAMENTO')
        <div class="text-center font-bold pt-3">Custos por Relacionamento</div>
    @elseif($tipoTable == 'veic.TIPO')
        <div class="text-center font-bold pt-3">Custos por Modelo</div>
    @endif
    <div  class="flex mb-2">
        <div class="relative h-10 input-component">
            <x-select
                placeholder="Selecione a perspectiva"
                :options="[
                    ['name' => 'Veículo',  'id' => 'cb.placa'],
                    ['name' => 'Unidade', 'id' => 'cb.unidade'],
                    ['name' => 'Rota',   'id' => 'cb.set_'],
                    ['name' => 'Relacionamento',    'id' => 'veic.RELACIONAMENTO'],
                    ['name' => 'Modelo',    'id' => 'veic.TIPO'],
                ]"
                option-label="name"
                option-value="id"
                wire:model="tipoTable"
            />
        </div>
    </div>
    <x-loading-table/>
    <div wire:loading.class="hidden" class="overflow-auto max-h-80">
        @if(count($tablePlacas) > 0)
        <table class="table-auto border-collapse w-full mt-4" >
            <thead>
            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                @foreach($tablePlacas[0] ?? [] as $key => $value)
                    @if($key == 'placa')
                        <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Veículo</th>
                    @elseif($key == 'set_')
                        <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Rota</th>
                    @elseif($key == 'unidade')
                        <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Unidade</th>
                    @elseif($key == 'RELACIONAMENTO')
                        <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Relacionamento</th>
                    @elseif($key == 'TIPO')
                        <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Modelo</th>
                    @else
                        <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">{{$key}}</th>
                    @endif
                @endforeach
            </tr>
            </thead>
            <tbody class="text-sm font-normal text-gray-700 w-full">
            @foreach($tablePlacas as $row)
                <tr class="hover:bg-gray-100 border-b border-gray-200 py-2">
                    @foreach($row as $key => $value)
                        @if($key == 'Custo (KG)' ||$key == '(R$) Mercadoria' || $key == '(R$) Frete' || $key == 'Custo (M3)')
                            <td class="px-4 py-1 w-22">{{formatReceita($value ?? 0)}}</th>
                        @elseif($key == 'placa')
                            <td class="px-4 py-1 w-22">
                                <div>
                                    <div class="h-12 w-32 border-black border-4 rounded-lg flex flex-col">
                                        <div class="bg-blue-800 h-3 flex flex-row">
                                            <div class="mr-1 flex items-center justify-center">
                                                <div class=" font-bold text-white ml-1 " style="font-size: 3px; width: 10px">Mercosul</div>
                                            </div>
                                            <div class="flex-1 text-center text-white mb-1 font-bold -mt-1" style="font-size: 8px;">Brasil</div>
                                            <div class="mr-1">
                                                <img src="{{url('logo/brasil.png')}}" class="h-3" alt="brasil">
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <div class="font-bold text-xl">{{$value}}</div>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        @elseif($key == 'Peso')
                            <td class="px-4 py-1 w-22">{{formatPeso($value ?? 0)}}</th>
                        @elseif($key == 'Cubagem')
                            <td class="px-4 py-1 w-22">{{formatM3($value ?? 0)}}</th>
                        @elseif($key == 'Diária/Frete')
                            <td class="px-4 py-1 w-22">{{formatPorcent($value ?? 0)}}%</th>
                        @else
                            <td class="px-4 py-1">{{$value ?? '0'}}</th>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
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
    thead tr th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px;}
    thead tr th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px;}
    tbody tr td:first-child { border-top-left-radius: 5px; border-bottom-left-radius: 0px;}
    tbody tr td:last-child { border-top-right-radius: 5px; border-bottom-right-radius: 0px;}
</style>
