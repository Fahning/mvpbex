<div class="mt-6  border  shadow-md rounded-md p-4 bg-white mx-8 ">
    <div class="flex justify-center">
        <div class="grid grid-cols-1 gap-4 w-2/3">
            <div class="text-center font-bold text-4xl ">
                {{formatReceita($newMeta)}}
            </div>
            <div class="text-md text-center font-serif  font-bold">
                Meta de Faturamento do Próximo Mês
            </div>
        </div>
    </div>
    <div class="flex justify-center w-full mt-6">
        <form method="post" wire:submit.prevent="newMeta" class="flex">

            <select name="tipo" id="tipo" wire:model="tipo" class="rounded-md mx-2">
                <option value="1">Dinheiro</option>
                <option value="2">Porcentagem</option>
            </select>
            @if($tipo == "1")
                <div class="flex">
                <span class="border-l border-t border-b bg-white border-gray-600 rounded-l-md ">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-8 mt-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                    <input type="number"  placeholder="Informe o valor em Reais"  name="dinheiro" id="dinheiro" wire:model.defer="dinheiro" class="rounded-r-md border-r border-t border-b">
                </div>
            @else
                <div class="flex">
                <span class="border-l border-t border-b bg-white border-gray-600 rounded-l-md ">
                    <div class="h-6 w-8 font-bold mt-2 text-center">%</div>
                </span>
                    <input type="number" placeholder="Informe a Porcentagem" name="porcentagem" prefix="R$" id="porcentagem" wire:model.defer="porcentagem" class="rounded-r-md border-r border-t border-b">
                </div>
            @endif

            <button class="mx-2 border border-gray-400 rounded-md p-2 hover:bg-gray-500" >Definir Meta</button>
        </form>
    </div>
    <div class="text-center text-red-600 mt-2">
        @error('dinheiro') <span>{{ $message }}</span> @enderror
        @error('porcentagem') <span>{{ $message }}</span> @enderror
    </div>


</div>
