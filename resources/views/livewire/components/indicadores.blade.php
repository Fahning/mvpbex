<div>
    <div class="grid grid-cols-4 gap-4">
        @foreach($indicators as $key => $indicator)

            <div class="{{$indicator > 0 ? 'bg-white' : 'bg-red-300'}} p-3 border shadow-md shadow-red rounded-md">
                <p class="font-bold">{{ $key }}</p>
                @if ($key == 'Desvio')
                    <p>{{ formatPorcent($indicator) }}%</p>
                @else
                    <p>{{ formatReceita($indicator) }}</p>
                @endif
            </div>
        @endforeach
    </div>


</div>
