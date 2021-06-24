<div class="ml-3 relative">
    <x-jet-dropdown align="right">
        <x-slot name="trigger">
            <div class="rounded-full bg-white shadow-md p-1  {{count($insights) == 0 ? 'cursor-not-allowed' : 'cursor-pointer'}}" title="{{count($insights) == 0 ? 'Nenhum Insight no momento' : ''}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{count($insights) == 0 ? 'text-gray-200' : 'text-gray-400'}}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if (count($insights) > 0)
                    <div class="absolute top-0 right-0 -mt-2 -mr-1.5 px-1.5 py-0.5 bg-blue-200 rounded-full" style="font-size: 10px">
                        {{count($insights)}}
                    </div>
                @endif
            </div>
        </x-slot>
        <x-slot name="content">
            @if (count($insights) > 0)
                <!-- Lista de Insights -->
                <div class="px-4 py-2 text-xs text-gray-400 ">
                    {{'Lista de Insights'}}
                </div>
                <div class="overflow-auto max-h-80">
                    @foreach($insights as $insight)
                        <div class="border-t-2 border-white"></div>
                        <div wire:click.prevent="abreModal({{$insight->id}})" class="grid grid-cols-1 bg-gray-100 p-2 cursor-pointer hover:bg-gray-200" style="width: 400px" title="{{$insight->descricao}}">
                            <div class="flex justify-between">
                                <div class="text-sm font-bold uppercase font text-gray-700">
                                    {{ $insight->tipo }}
                                </div>
                                <div class="font-thin italic text-gray-700">
                                    {{ \Carbon\Carbon::create($insight->sk_data)->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="border-t-1 border-gray-500"></div>
                            <div class="text-sm text-gray-700 text-sm truncate ">
                                {{$insight->descricao}}
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
        </x-slot>
    </x-jet-dropdown>
</div>
@livewire('components.menus.modal-insight')
