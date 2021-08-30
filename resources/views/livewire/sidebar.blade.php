<div class="flex flex-shrink-0 transition-all w-full h-screen">
    <div class="flex flex-shrink-0 transition-all overflow-y-auto">
        <div
            x-show="isSidebarOpen"
            @click="isSidebarOpen = false"
            class="fixed inset-0 z-10 bg-black bg-opacity-50 lg:hidden"
        ></div>
        <div x-show="isSidebarOpen" class="fixed inset-y-0 z-10 w-16 bg-white"></div>

        <!-- Mobile bottom bar -->
        <nav
            aria-label="Options"
            class="fixed inset-x-0 bottom-0 flex flex-row-reverse items-center justify-between px-4 py-2 bg-white border-t border-indigo-100 sm:hidden shadow-t rounded-t-3xl"
        >
            <!-- Menu button -->
            <button
                @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'"
                class="p-2 transition-colors rounded-lg shadow-md hover:bg-indigo-800 hover:text-white focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-indigo-600' : 'text-gray-500 bg-white'"
            >
                <span class="sr-only">Toggle sidebar</span>
                <svg
                    aria-hidden="true"
                    class="w-6 h-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="#">
                <img
                    class="w-20 h-auto"
                    src="{{url('logo/Bex-principal.png')}}"
                    alt="Bex Logo"
                />
            </a>

            <!-- User avatar button -->
            <div class="relative flex items-center flex-shrink-0 p-2" x-data="{ isOpen: false }">
                <button
                    @click="isOpen = !isOpen; $nextTick(() => {isOpen ? $refs.userMenu.focus() : null})"
                    class="transition-opacity rounded-lg opacity-80 hover:opacity-100 focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                >
                    <img
                        class="w-10 h-10 rounded-lg shadow-md object-cover"
                        src="{{ asset('logo/bex-avatar.svg') }}"
                        alt=""
                    />
                    <span class="sr-only">User menu</span>
                </button>
                <div
                    x-show="isOpen"
                    @click.away="isOpen = false"
                    @keydown.escape="isOpen = false"
                    x-ref="userMenu"
                    class="absolute z-10 w-48 py-1 mt-2 origin-bottom-left bg-white rounded-md shadow-lg left-10 bottom-14 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-label="user menu"
                >
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                    >Perfil</a
                    >

                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Configuração</a>

                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sair</a>
                </div>
            </div>
        </nav>

        <!-- Left mini bar -->
        <nav
            aria-label="Options"
            class="z-20 flex-col items-center flex-shrink-0 hidden w-16 py-4 bg-white border-r-2 border-indigo-100 shadow-md sm:flex rounded-tr-3xl rounded-br-3xl"
        >
            <!-- Logo -->
            <div class="flex-shrink-0 py-4">
                <a href="#">
                    <img
                        class="w-10 h-auto"
                        src="{{url('logo/Bex-principal.png')}}"
                        alt="Logo Bex"
                    />
                </a>
            </div>
            <div class="flex flex-col items-center flex-1 p-2 space-y-4">
                <!-- Menu button -->
                <button
                    @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'"
                    class="p-2 transition-colors rounded-lg shadow-md hover:bg-indigo-800 hover:text-white focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                    :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-indigo-600' : 'text-gray-500 bg-white'"
                >
                    <span class="sr-only">Toggle sidebar</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
                <!-- Messages button -->
                <button
                    @click="(isSidebarOpen && currentSidebarTab == 'messagesTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'messagesTab'"
                    class="p-2 transition-colors rounded-lg shadow-md hover:bg-indigo-800 hover:text-white focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                    :class="(isSidebarOpen && currentSidebarTab == 'messagesTab') ? 'text-white bg-indigo-600' : 'text-gray-500 bg-white'"
                >
                    <span class="sr-only">Toggle message panel</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                        />
                    </svg>
                </button>
                <!-- Notifications button -->
                <div class="flex">
                    <div class="absolute {{count($insights) > 0 ? 'animate-bounce' : ''}} -mt-2 -mr-5 bg-blue-300 text-white px-1.5 py-0.5 rounded-full" style="font-size: 10px">
                        {{count($insights)}}
                    </div>
                    <button
                        @click="(isSidebarOpen && currentSidebarTab == 'notificationsTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'notificationsTab'"
                        class="p-2 transition-colors rounded-lg shadow-md hover:bg-indigo-800 hover:text-white focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                        :class="(isSidebarOpen && currentSidebarTab == 'notificationsTab') ? 'text-white bg-indigo-600' : 'text-gray-500 bg-white'"
                    >
                        <span class="sr-only">Toggle notifications panel</span>
                        <svg
                            aria-hidden="true"
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                            />
                        </svg>
                    </button>
                </div>

            </div>

            <!-- User avatar -->
            <div class="relative flex items-center flex-shrink-0 p-2" x-data="{ isOpen: false }">
                <button
                    @click="isOpen = !isOpen; $nextTick(() => {isOpen ? $refs.userMenu.focus() : null})"
                    class="transition-opacity rounded-lg opacity-80 hover:opacity-100 focus:outline-none focus:ring focus:ring-indigo-600 focus:ring-offset-white focus:ring-offset-2"
                >
                    <img
                        class="w-10 h-10 rounded-lg shadow-md object-cover"
                        src="{{ asset('logo/bex-avatar.svg') }}"
                        alt=""
                    />
                    <span class="sr-only">Menu do Usuario</span>
                </button>
                <div
                    x-show="isOpen"
                    @click.away="isOpen = false"
                    @keydown.escape="isOpen = false"
                    x-ref="userMenu"
                    tabindex="-1"
                    class="fixed w-48 py-1 mt-2 origin-bottom-left bg-white rounded-md shadow-lg left-10 bottom-14 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-label="user menu"
                >
                    <a href="{{route('profile.show')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                    >Perfil</a
                    >

                    {{--                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Configurações</a>--}}

                    <form method="POST" action="{{ route('logout') }}" class="block  py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        @csrf
                        <button type="submit" class="w-full text-left px-4" >Sair</button>
                    </form>

                </div>
            </div>
        </nav>

        <div
            x-transition:enter="transform transition-transform duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition-transform duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            x-show="isSidebarOpen"
            class="fixed inset-y-0 left-0 z-10 flex-shrink-0 w-64 bg-white border-r-2 border-indigo-100 shadow-lg sm:left-16 rounded-tr-3xl rounded-br-3xl sm:w-72 lg:static lg:w-64"
        >
            <nav x-show="currentSidebarTab == 'linksTab'" aria-label="Main" class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center flex-shrink-0 py-10">
                    <a href="#">
                        <img
                            class="w-28 h-auto"
                            src="{{url('logo/Bex-principal.png')}}"
                            alt="Logo Bex"
                        />
                    </a>
                </div>

                <!-- Links -->

                <div class="flex-1 px-4 space-y-2 overflow-hidden hover:overflow-auto">
                    <!-- MENU COMPANIAS-->
                {{--                    <a href="{{route('companies')}}" class="flex items-center w-full space-x-2 text-white bg-indigo-600 rounded-lg">--}}
                {{--                      <span aria-hidden="true" class="p-2 bg-indigo-700 rounded-lg">--}}
                {{--                        <svg--}}
                {{--                            class="w-6 h-6"--}}
                {{--                            xmlns="http://www.w3.org/2000/svg"--}}
                {{--                            fill="none"--}}
                {{--                            viewBox="0 0 24 24"--}}
                {{--                            stroke="currentColor"--}}
                {{--                        >--}}
                {{--                          <path--}}
                {{--                              stroke-linecap="round"--}}
                {{--                              stroke-linejoin="round"--}}
                {{--                              stroke-width="2"--}}
                {{--                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"--}}
                {{--                          />--}}
                {{--                        </svg>--}}
                {{--                      </span>--}}
                {{--                        <span>Empresas</span>--}}
                {{--                    </a>--}}

                    <!-- MENU DASHBOARD-->
                    <a href="{{route('dashboard')}}" class="flex items-center w-full space-x-2 text-white bg-indigo-600 rounded-lg">
                      <span aria-hidden="true" class="p-2 bg-indigo-700 rounded-lg">
                        <svg
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                          <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                          />
                        </svg>
                      </span>
                        <span>Dashboard</span>
                    </a>

                    <!-- MENU MOVIMENTAÇÕES-->
                    <div x-data="{ openMovimentacoes: false }">
                        <a href="{{route('movimentacoes')}}"
                            @click="openMovimentacoes = !openMovimentacoes"
                            class="flex items-center w-full space-x-2 group rounded-lg hover:bg-indigo-600 hover:text-white"
                            :class="openMovimentacoes ? 'bg-indigo-600 text-white' : 'text-indigo-600'"
                        >
                            <span aria-hidden="true" class="p-2 rounded-lg group-hover:bg-indigo-700 group-hover:text-white"

                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </span>
                            <span>Movimentações</span>
                        </a>
                    </div>

                    <!-- MENU OPERACIONA-->
                    <div class="flex flex-col" x-data="{ openOperacional: false }">
                        <a
                            href="#"
                            @click="openOperacional = !openOperacional"
                            class="flex items-center space-x-2 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            :class="openOperacional ? 'bg-indigo-600 text-white' : 'text-indigo-600'"
                        >
                      <span
                          aria-hidden="true"
                          :class="'p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white'"
                      >
                        <svg
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                          <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                          />
                        </svg>
                      </span>
                            <span>Operacional</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} :d="openOperacional ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" />
                            </svg>
                        </a>
                        <div
                            class="bg-gray-100 rounded-md m-1"
                            x-show="openOperacional"
                            x-transition:enter="transform-gpu ease-out duration-200"
                            x-transition:enter-start="-translate-y-2 opacity-0"
                            x-transition:leave="transform-gpu ease-out duration-200"
                            x-transition:leave-end="-translate-y-2 opacity-0"
                        >
                            <a
                                href="{{route('analise-custos')}}"
                                class="flex items-center space-x-2 text-indigo-600 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            >
                            <span
                                aria-hidden="true"
                                class="p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                  <path
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                  />
                                </svg>
                            </span>
                                <span>Análise de Custos</span>
                            </a>
                            <a
                                href="{{route('inventario')}}"
                                class="flex items-center space-x-2 text-indigo-600 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            >
                                <span
                                    aria-hidden="true"
                                    class="p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                      <path
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                      />
                                    </svg>
                                </span>
                                <span>Inventario</span>
                            </a>
                            <a
                                href="{{route('meta-custos')}}"
                                class="flex items-center space-x-2 text-indigo-600 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            >
                            <span
                                aria-hidden="true"
                                class="p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                  <path
                                      stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                                  />
                                </svg>
                            </span>
                                <span>Definir Metas</span>
                            </a>
                        </div>
                    </div>

                    <!-- MENU FINANCEIRO-->
                    <div class="flex flex-col" x-data="{ openFinanceiro: false }"
                    >
                        <a
                            href="#"
                            @click="openFinanceiro = !openFinanceiro"
                            class="flex items-center space-x-2 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            :class="openFinanceiro ? 'bg-indigo-600 text-white' : 'text-indigo-600'"
                        >
                      <span
                          aria-hidden="true"
                          :class="'p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white'"
                      >
                        <svg
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                          <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                          />
                        </svg>
                      </span>
                            <span>Financeiro</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} :d="openFinanceiro ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'" />
                            </svg>
                        </a>
                        <div class="bg-gray-100 rounded-md m-1" x-show="openFinanceiro"
                             x-transition:enter="transform-gpu ease-out duration-200"
                             x-transition:enter-start="-translate-y-2 opacity-0"
                             x-transition:leave="transform-gpu ease-out duration-200"
                             x-transition:leave-end="-translate-y-2 opacity-0"
                        >
                            <a
                                href="{{route('financeiro')}}"
                                class="flex items-center space-x-2 text-indigo-600 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            >
                      <span
                          aria-hidden="true"
                          class="p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white"
                      >
                        <svg
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                          <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                          />
                        </svg>
                      </span>
                                <span>Faturamento</span>
                            </a>
                            <a
                                href="{{route('definir-meta')}}"
                                class="flex items-center space-x-2 text-indigo-600 transition-colors rounded-lg group hover:bg-indigo-600 hover:text-white"
                            >
                      <span
                          aria-hidden="true"
                          class="p-2 transition-colors rounded-lg group-hover:bg-indigo-700 group-hover:text-white"
                      >
                        <svg
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                          <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                          />
                        </svg>
                      </span>
                                <span>Definir Meta</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <section x-show="currentSidebarTab === 'messagesTab'" class="px-4 py-6">
                <h2 class="text-xl">Mensagens</h2>
            </section>

            <section x-show="currentSidebarTab === 'notificationsTab'" class="px-2 py-5">
                <h2 class="text-xl">Insights</h2>
                <div class="overflow-auto" style="max-height: 87vh">
                    @foreach($insights as $insight)
                        <div class="border-t-2 border-white"></div>
                        <div @click="currentSidebarTab = 'notificationsTab'; abreInsight({{$insight->id}}); isModelInsightOpen = true" class="grid grid-cols-1 bg-blue-100 p-2 rounded-md cursor-pointer hover:bg-blue-200 w-56"  title="{{$insight->descricao}}">
                            <div class="flex justify-between">
                                <div class="text-xs font-bold uppercase font text-gray-700">
                                    {{ $insight->tipo }}
                                </div>
                                <div class="font-thin text-xs italic text-gray-700">
                                    {{ \Carbon\Carbon::create($insight->sk_data)->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="border-t-1 border-gray-500"></div>
                            <div class="text-xs text-gray-700">
                                {{$insight->descricao}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    <div class="flex flex-col flex-1">
        <header class="relative flex items-center justify-between flex-shrink-0 p-4">
            <form action="#" class="flex-1 font-bold text-xl">
                <!--Pagina Atual  -->
                {{ucwords(str_replace('-', ' ', Route::currentRouteName()))}}
            </form>
            <div class="items-center hidden ml-4 sm:flex">
                @if(\Illuminate\Support\Facades\Route::current()->getName() != 'movimentacoes')
                    <button
                        @click="isSettingsPanelOpen = true"
                        title="Filtros"
                        class="p-2 mr-4 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4"
                    >
                        <span class="sr-only">Configurações</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </button>
                @endif

                <!-- Github link -->
                {{--                    <a--}}
                {{--                        href=""--}}
                {{--                        target="_blank"--}}
                {{--                        class="p-2 text-white bg-blue-600 rounded-lg shadow-md hover:text-gray-200 focus:outline-none focus:ring focus:ring-black focus:ring-offset-gray-100 focus:ring-offset-2"--}}
                {{--                    >--}}
                {{--                        <span class="sr-only">Banco Conectado</span>--}}
                {{--                        <div>--}}
                {{--                            {{ Config::get('database.connections.tenant.database') }}--}}
                {{--                        </div>--}}

                {{--                    </a>--}}
            </div>

            <!-- Mobile sub header button -->
            <button
                @click="isSubHeaderOpen = !isSubHeaderOpen"
                class="p-2 text-gray-400 bg-white rounded-lg shadow-md sm:hidden hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4"
            >
                <span class="sr-only">More</span>

                <svg
                    aria-hidden="true"
                    class="w-6 h-6"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"
                    />
                </svg>
            </button>

            <!-- Mobile sub header -->
            <div
                x-transition:enter="transform transition-transform"
                x-transition:enter-start="translate-y-full opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transform transition-transform"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="translate-y-full opacity-0"
                x-show="isSubHeaderOpen"
                @click.away="isSubHeaderOpen = false"
                class="absolute flex items-center justify-between p-2 bg-white rounded-md shadow-lg sm:hidden top-16 left-5 right-5"
            >
                <!-- Seetings button -->
                <button
                    @click="isSettingsPanelOpen = true; isSubHeaderOpen = false"
                    class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4"
                >
                    <span class="sr-only">Configuração</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </button>
                <!-- Messages button -->
                <button
                    @click="isSidebarOpen = true; currentSidebarTab = 'messagesTab'; isSubHeaderOpen = false"
                    class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4"
                >
                    <span class="sr-only">Toggle message panel</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                        />
                    </svg>
                </button>
                <!-- Notifications button -->
                <button
                    @click="isSidebarOpen = true; currentSidebarTab = 'notificationsTab'; isSubHeaderOpen = false"
                    class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:text-gray-600 focus:outline-none focus:ring focus:ring-white focus:ring-offset-gray-100 focus:ring-offset-4"
                >
                    <span class="sr-only">Toggle notifications panel</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                        />
                    </svg>
                </button>
                <!-- Github link -->
                {{--        <a--}}
                {{--            href="https://github.com/kamona-ui/dashboard-alpine"--}}
                {{--            target="_blank"--}}
                {{--            class="p-2 text-white bg-black rounded-lg shadow-md hover:text-gray-200 focus:outline-none focus:ring focus:ring-black focus:ring-offset-gray-100 focus:ring-offset-2"--}}
                {{--        >--}}
                {{--            <span class="sr-only">github link</span>--}}
                {{--            <svg--}}
                {{--                aria-hidden="true"--}}
                {{--                class="w-6 h-6"--}}
                {{--                fill="currentColor"--}}
                {{--                xmlns="http://www.w3.org/2000/svg"--}}
                {{--                viewBox="0 0 24 24"--}}
                {{--            >--}}
                {{--                <path--}}
                {{--                    fill-rule="evenodd"--}}
                {{--                    clip-rule="evenodd"--}}
                {{--                    d="M12.026,2c-5.509,0-9.974,4.465-9.974,9.974c0,4.406,2.857,8.145,6.821,9.465 c0.499,0.09,0.679-0.217,0.679-0.481c0-0.237-0.008-0.865-0.011-1.696c-2.775,0.602-3.361-1.338-3.361-1.338 c-0.452-1.152-1.107-1.459-1.107-1.459c-0.905-0.619,0.069-0.605,0.069-0.605c1.002,0.07,1.527,1.028,1.527,1.028 c0.89,1.524,2.336,1.084,2.902,0.829c0.091-0.645,0.351-1.085,0.635-1.334c-2.214-0.251-4.542-1.107-4.542-4.93 c0-1.087,0.389-1.979,1.024-2.675c-0.101-0.253-0.446-1.268,0.099-2.64c0,0,0.837-0.269,2.742,1.021 c0.798-0.221,1.649-0.332,2.496-0.336c0.849,0.004,1.701,0.115,2.496,0.336c1.906-1.291,2.742-1.021,2.742-1.021 c0.545,1.372,0.203,2.387,0.099,2.64c0.64,0.696,1.024,1.587,1.024,2.675c0,3.833-2.33,4.675-4.552,4.922 c0.355,0.308,0.675,0.916,0.675,1.846c0,1.334-0.012,2.41-0.012,2.737c0,0.267,0.178,0.577,0.687,0.479 C19.146,20.115,22,16.379,22,11.974C22,6.465,17.535,2,12.026,2z"--}}
                {{--                ></path>--}}
                {{--            </svg>--}}
                {{--        </a>--}}
            </div>
        </header>


        <div class="flex flex-1">
            <!-- Main -->
            <main class="w-full overflow-auto px-5" style="max-height: 86vh">
                @yield('corpo-site')
            </main>
        </div>
    </div>
</div>

<script>
    function abreInsight(id){
        Livewire.emit('carregaInsight', id)
    }
</script>
