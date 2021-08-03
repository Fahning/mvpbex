<div class="bg-white shadow-md pb-4 px-4 rounded-md w-full">
    <div class="text-center font-bold mp-4">Analise comercial de segmento ({{monthToString($month)}} de {{$year}})</div>
    <div class="overflow-auto max-h-80">
        <div  wire:loading class="w-full max-h-80">
            <div class="animate-pulse flex space-x-4">
                <div class="flex-1 space-y-4 py-1">
                    <div class="h-8 bg-gray-400 rounded"></div>
                </div>
            </div>
            <div class="animate-pulse flex space-x-1 mt-5">
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
            </div>
            <div class="animate-pulse flex space-x-1 mt-5">
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
            </div>
            <div class="animate-pulse flex space-x-1 mt-5">
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
            </div>
            <div class="animate-pulse flex space-x-1 mt-5">
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
                <div class="h-4  w-full bg-gray-400 rounded"></div>
            </div>
        </div>

        <table wire:loading.class="hidden" class="table-auto border-collapse w-full mt-4" >
            <thead>
            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                @foreach($table[0] ?? [] as $key => $value)
                    <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody class="text-sm font-normal text-gray-700 w-full">
                @foreach($table as $row)
                    <tr class="hover:bg-gray-100 border-b border-gray-200 py-2">
                        @foreach($row as $key => $value)
                            @if($key == "TKM" || $key == "RPK" )
                                <td class="px-4 py-1">{{formatReceita($value)}}</th>
                            @elseif($key == '% Frete/Valor Mercadoria')
                                <td class="px-4 py-1">{{formatPorcent($value)}}%</th>
                            @elseif($key == "Qtde CTRC")
                                <td class="px-4 py-0.5">
                                    <div class="relative">
                                        <div class="overflow-hidden h-7 text-xs flex rounded bg-pink-200">
                                            <div style="width:{{number_format(($value/$maior) * 100, 2, '.', '')}}%" class="shadow-none flex flex-col  whitespace-nowrap text-white justify-center bg-pink-500">
                                                <div class="font-bold text-black px-3">
                                                    {{$value}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            @else
                                <td class="px-4 py-1">{{$value}}</th>
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
