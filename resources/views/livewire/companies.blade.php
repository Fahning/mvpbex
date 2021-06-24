<div>
    <div class="grid grid-cols-6 justify-center mt-6">
        <div class="grid justify-center content-center col-span-2">
            <span class="text-gray-500 text-xl">Cadastrar Nova empresa</span>
        </div>
        <div class="border p-3 rounded-md bg-white mr-10 shadow-md col-span-4">
            <form class="grid grid-cols-2" wire:submit.prevent="create" method="post">
                <div class="px-3">
                    <input class="rounded mb-3 w-full" type="text" name="name" id="name" wire:model="name" placeholder="Nome Empresa">
                    @error('name') {{$message}} @enderror
                </div>
                <div class="px-3">
                    <input class="rounded mb-3 w-full" type="text" name="cnpj" id="cnpj" wire:model="cnpj" placeholder="CNPJ Empresa">
                    @error('cnpj') {{$message}} @enderror
                </div>
                <div class="px-3">
                    <input class="rounded mb-3 w-full" type="text" name="database" id="database" wire:model="database"  placeholder="Database Empresa">
                    @error('database') {{$message}} @enderror
                </div>
                <div class="px-3">
                    <input class="rounded mb-3 w-full" type="text" name="hostname" id="hostname" wire:model="hostname"  placeholder="Hostname do banco">
                    @error('hostname') {{$message}} @enderror
                </div>
                <div class="px-3">
                    <input class="rounded mb-3 w-full" type="text" name="username" id="username" wire:model="username"  placeholder="Username do banco">
                    @error('username') {{$message}} @enderror
                </div>
                <div class="px-3">
                    <input class="rounded mb-3 w-full" type="password" name="password" id="password" wire:model="password"  placeholder="Senha do banco">
                </div>
                <div class="px-3">
                    <button type="submit" class="bg-transparent hover:bg-blue-500 text-gray-700 font-semibold hover:text-white py-2 px-8 w-full border border-gray-500 hover:border-transparent rounded">
                        Cadastrar Empresa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-5">
        <hr>
    </div>


    <div class="grid grid-cols-6 justify-center mt-6">
        <div class="grid justify-center content-center col-span-2">
            <span class="text-gray-500 text-xl">Empresas Cadastradas</span>
        </div>

        <div class="grid grid-cols-2 mr-10 border rounded-md bg-white shadow-md col-span-4">
                @foreach($companies as $company)

                    <div wire:click="edit" class="h-20 m-2 bg-gray-100 border-gray-600 dark:bg-gray-200 bg-opacity-95 border-opacity-60 | p-2 border-solid rounded-md border | flex justify-around cursor-pointer | hover:bg-gray-400 dark:hover:bg-gray-600 hover:border-transparent | transition-colors duration-500">
                        <div class="flex flex-col justify-center">
                            <p class="text-gray-900 dark:text-gray-300 font-semibold">
                                <span class="text-gray-900 dark:text-gray-300 font-bold">Nome:</span> {{$company->name}}
                            </p>
                            <p class="text-black dark:text-gray-100 text-justify font-semibold">
                                <span class="text-gray-900 dark:text-gray-300 font-bold">CNPJ:</span> {{$company->cnpj}}
                            </p>

                            <p class="text-black dark:text-gray-100 text-justify font-semibold">
                                <span class="text-gray-900 dark:text-gray-300 font-bold">Dominio:</span> {{$company->domain}}
                            </p>
                        </div>
                    </div>
                @endforeach
        </div>

    </div>

    <div class="mt-5">
        <hr>
    </div>

    <div class="grid justify-center mx-6">
        {{ $companies->links() }}
    </div>
</div>
