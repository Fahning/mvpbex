<div>
    <div class="alert flex flex-row items-center bg-blue-200 p-2 rounded border-b-2 border-blue-300">
        <div class="alert-icon flex items-center bg-blue-100 border-2 border-blue-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
				<span class="text-blue-500">
					<svg fill="currentColor"
                         viewBox="0 0 20 20"
                         class="h-6 w-6">
						<path fill-rule="evenodd"
                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                              clip-rule="evenodd"></path>
					</svg>
				</span>
        </div>
        <div class="alert-content ml-4">
            <div class="alert-title font-semibold text-lg text-blue-800">
                Informação
            </div>
            <div class="alert-description text-sm text-blue-600">
                Para esse período, há {{$ctrb_os->total}} registros com o campo CTRB-OS nulo ou em branco.
            </div>
        </div>
    </div>

    <div class="flex flex-wrap justify-center">
        @foreach ($cards as $key => $card)
            <div class="flex flex-col items-center bg-white justify-center border shadow rounded-xl w-56 h-32 m-10">
                <span class="flex items-center shadow-lg justify-center font-bold text-md text-white bg-blue-500 rounded-xl -mt-9 w-48 h-16">{{ $key }}</span>
                <span class="text-center font-bold mt-7 text-2xl">{{formatReceita($card)}}</span>
            </div>
        @endforeach
    </div>
</div>
