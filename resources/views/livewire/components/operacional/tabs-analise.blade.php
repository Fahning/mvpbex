<div >
    <!--actual component start-->
    <div>
        <ul class="flex justify-center items-center ">
            <li wire:click="tab(1)" class="cursor-pointer py-2 px-4 border-b-8 {{$tab == 1 ? 'text-blue-500 border-blue-500' : 'text-blue-400'}}">
                Análise de Coleta
            </li>
            <li wire:click="tab(2)" class="cursor-pointer py-2 px-4 border-b-8 {{$tab == 2 ? 'text-blue-500 border-blue-500' : 'text-blue-400'}}">
                Análise de Transferencia
            </li>
            <li wire:click="tab(3)" class="cursor-pointer py-2 px-4 border-b-8 {{$tab == 3 ? 'text-blue-500 border-blue-500' : 'text-blue-400'}}">
                Análise de Entrega
            </li>
        </ul>

        <div class="">
            @if($tab == 1)
                @livewire('components.operacional.analise-de-coleta')
            @elseif($tab == 2)
                @livewire('components.operacional.analise-de-transferencia')
            @elseif($tab == 3)
                @livewire('components.operacional.analise-de-entrega')
            @endif
            <div
                 wire:loading class="absolute inset-0 text-white bg-black bg-opacity-50 w-full h-full" aria-hidden="true"
            >
                <span class="flex justify-center items-center h-screen">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-24 w-24" style="margin: auto;  display: block; shape-rendering: auto;" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <circle cx="50" cy="50" fill="none" stroke="#a4a1a1" stroke-width="7" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                          <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </circle>
                    </svg>
                </span>
            </div>
        </div>

    </div>
    <!--actual component end-->
</div>
