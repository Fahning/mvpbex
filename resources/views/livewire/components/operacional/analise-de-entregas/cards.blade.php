<div CLASS="grid grid-cols-1 w-full">
    <x-loading-cards-custos/>

    <div wire:loading.class="hidden"  class="w-full grid grid-cols-6 gap-4">
        @foreach($cards as $key => $card)
            <div title="indice : Fat. = Faturamento"  class="bg-white w-full p-2 h-20 border shadow-md shadow-red rounded-md ">
                <div class="flex flex-col text-xl h-full justify-center">
                    <p class="font-bold text-sm text-gray-400">{{ $key }}</p>
                    @if($key == 'Total de Volumes' || $key == 'Coletas Com OS' || $key == 'Coletas Sem OS')
                        <p >{{ $card }}</p>
                    @elseif($key == '% Custo/Fat. (Peso)' || $key == '% Custo/Fat. (Cubagem)' || $key == 'Meta de Custo')
                        <p >{{ formatPorcent($card) }} %</p>
                    @else
                        <p >{{ formatReceita($card) }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
