<div class="bg-white shadow-md pb-4 px-4 rounded-md w-full">
    <div class="text-center font-bold mt-4">Analise de desvios no faturamento por segmento ({{$month}} de {{$year}})</div>
    <div class="overflow-auto max-h-80">
        <table class="table-auto border-collapse w-full mt-4">
            <thead>
            <tr class="rounded-lg text-sm font-medium text-gray-700 text-left" style="font-size: 0.9674rem">
                @foreach($table[0] as $key => $value)
                    <th class="px-4 py-2 bg-gray-200 " style="background-color:#f8f8f8">{{$key}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody class="text-sm font-normal text-gray-700 w-full">
            @foreach($table as $row)
                <tr class="hover:bg-gray-100 border-b border-gray-200 py-2">
                    @foreach($row as $key => $value)
                        @if($key == 'Realizado' || $key == 'Meta' || $key == 'Media' || $key == 'Desvio (R$)')
                            <td class="px-4 py-1">{{formatReceita($value)}}</th>
                        @elseif($key == 'Mês')
                            <td class="px-4 py-1">{{ monthToString($value) }}</th>
                        @elseif($key == 'Desvio (%)')
                            <td class="px-4 py-1">{{ $value }}%</th>
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
