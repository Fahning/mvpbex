<div class="grid grid-cols-1 bg-white shadow-md border-1 w-24 rounded-md p-2">
    @if ($farol == "VERMELHO")
        <div class="h-16 w-16 bg-red-600 rounded-full ml-2 mt-1 shadow-md border border-black">
        </div>
    @else
        <div class="h-16 w-16 bg-gray-200 rounded-full  ml-2 my-1 shadow-md">
        </div>
    @endif

    @if ($farol == "AMARELO")
        <div class="h-16 w-16 bg-yellow-300 rounded-full ml-2 mt-1 shadow-md border border-black">
        </div>
    @else
        <div class="h-16 w-16 bg-yellow-100 rounded-full  ml-2 my-1 shadow-md">
        </div>
    @endif

    @if ($farol == "VERDE")
        <div class="h-16 w-16 bg-green-500 rounded-full ml-2 mt-1 shadow-xl border border-black" >
        </div>
    @else
        <div class="h-16 w-16 bg-green-100 rounded-full  ml-2 my-1 shadow-md">
        </div>
    @endif
</div>
