<x-guest-layout >
    <div class="flex justify-center gap-4 mt-44">
        <div class=" w-2/6">
            <div class="flex justify-center mb-4">
                <span class="text-2xl text-gray-200 px-8 rounded-full bg-green-500">{{Config::get('database.connections.tenant.database')}}</span>
            </div>
            <div class="flex justify-center mb-4">
                <img class="w-80" src="{{ \Illuminate\Support\Facades\URL::asset('logo/Bex-principal.png')  }}" alt="Logo Bex">
            </div>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div >
                    <x-jet-label for="email" value="{{ __('Email') }}" class="font-bold text-white"/>
                    <x-jet-input id="email" class="active:bg-blue-500 block mt-1 w-full rounded-full bg-blue-500 border-gray-400 focus:hover:shadow-none" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Senha') }}" class="font-bold text-white"/>
                    <x-jet-input id="password" class="block mt-1 w-full rounded-full bg-blue-500 border-gray-400" type="password" name="password" required autocomplete="current-password" />
                </div>

{{--                <div class="block mt-4">--}}
{{--                    <label for="remember_me" class="flex items-center">--}}
{{--                        <x-jet-checkbox id="remember_me" name="remember" />--}}
{{--                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
                <div class="">
                    <button type="submit" class="mt-6 border border-gray-400 w-full text-center rounded-full bg-blue-500 border-gray-400 hover:bg-blue-600 hover:shadow-md hover:border-gray-400">
                        <div class="p-2 font-bold text-gray-300">{{ __('Logar') }}</div>
                    </button>
                </div>
                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-300 hover:text-gray-400" href="{{ route('password.request') }}">
                            {{ __('Recuperar Senha?') }}
                        </a>
                    @endif

                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
