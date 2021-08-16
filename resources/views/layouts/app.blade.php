<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;500;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <wireui:styles />
        <link rel="stylesheet" href="{{ URL::asset('css/floatInput.css') }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">r
        @livewireStyles


        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <wireui:scripts />
        <!-- HighCharts -->
        <script type="text/javascript" src="https://code.highcharts.com/stock/highstock.js"></script>

    </head>


    <body class="h-screen overflow-hidden flex items-center justify-center" style="background: #edf2f7;">
        <div class="w-full" x-data="setupMenu()" x-init="$refs.loading.classList.add('hidden');" @resize.window="watchScreen()">
            <div  class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
                <!-- Loading screen -->
                <div
                    x-ref="loading"
                    class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-indigo-800"
                >
                    Carregando.....
                </div>

                <!-- Sidebar -->
                @livewire('sidebar')

                @section('corpo-site')
                {{ $slot }}
                @stop

            </div>
            <!-- Filters Panel -->
            <div
                 x-show="isSettingsPanelOpen"
            >
                @livewire('components.menus.filtros')
            </div>

            <!-- MODAL INSIGHTS -->

            @livewire('components.menus.modal-insight')

        </div>

        @livewireChartsScripts
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
        <script src="{{ URL::asset('js/floatInput.js') }}" defer></script>
        @stack('modals')
        <livewire:scripts />
        @stack('scripts')
    </body>
</html>
<script>
    const setupMenu = () => {

        return {
            isSidebarOpen: false,
            currentSidebarTab: null,
            isSettingsPanelOpen: false,
            isModelInsightOpen: false,
            isSubHeaderOpen: false,
            watchScreen() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                }
            },
        }
    }
</script>




<style>
    /* Works on Firefox */
    * {
        scrollbar-width: thin;
        scrollbar-color: #6d6df3;
    }

    /* Works on Chrome, Edge, and Safari */
    *::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    *::-webkit-scrollbar-thumb {
        background-color: #6d6df3;
        border-radius: 20px;
    }
</style>
