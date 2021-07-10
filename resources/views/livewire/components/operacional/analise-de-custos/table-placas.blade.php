
<div class="bg-white shadow-md pb-4 px-4 rounded-md w-full">
    <div class="text-center font-bold mt-4">Custos por Veículo</div>
    <div class="overflow-auto max-h-80">
        <table class="table-auto border-collapse w-full mt-4" >
            <thead>
            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                @foreach($table[0] ?? [] as $key => $value)
                    @if($key == 'placa')
                    <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">Veículo</th>
                    @else
                    <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">{{$key}}</th>
                    @endif
                @endforeach
            </tr>
            </thead>
            <tbody class="text-sm font-normal text-gray-700 w-full">
            @foreach($table as $row)
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
                        @elseif($key == 'Custo % Frete')
                            <td class="px-4 py-1 w-22">{{formatPorcent($value ?? 0)}}%</th>
                        @else
                            <td class="px-4 py-1">{{$value ?? '0'}}</th>
                        @endif
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    thead tr th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px;}
    thead tr th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px;}
    tbody tr td:first-child { border-top-left-radius: 5px; border-bottom-left-radius: 0px;}
    tbody tr td:last-child { border-top-right-radius: 5px; border-bottom-right-radius: 0px;}
</style>
