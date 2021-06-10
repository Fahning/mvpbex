<div class="grid grid-cols-1 bg-white shadow-md border-1 w-24 rounded-md mx-6 p-2">
    @if ($farol < 0)
        <div class="h-16 w-16 bg-red-600 rounded-full ml-2 mt-1 shadow-md">
        </div>
    @else
        <div class="h-16 w-16 bg-gray-300 rounded-full  ml-2 my-1 shadow-md">
        </div>
    @endif

    @if ($farol > 0 && $farol < 0)
        <div class="h-16 w-16 bg-yellow-300 rounded-full ml-2 mt-1 shadow-md">
        </div>
    @else
        <div class="h-16 w-16 bg-yellow-100 rounded-full  ml-2 my-1 shadow-md">
        </div>
    @endif

    @if ($farol > 1)
        <div class="h-16 w-16 bg-green-500 rounded-full ml-2 mt-1 shadow-md" >
        </div>
    @else
        <div class="h-16 w-16 bg-green-100 rounded-full  ml-2 my-1 shadow-md">
        </div>
    @endif


</div>
