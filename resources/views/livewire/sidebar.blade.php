@livewire('layout.menu-top')
<div class="flex flex-col flex-1">
    @livewire('layout.menu-lateral')

    <div class="flex flex-1">
        <!-- Main -->
        <main class="w-full overflow-auto px-5" style="max-height: 86vh">
            {{ $slot }}
        </main>
{{--        @livewire('components.menus.modal-insight')--}}
    </div>
</div>
