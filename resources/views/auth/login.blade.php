<x-guest-layout>
    <x-auth-card>

        <x-slot name="logo">
            <a href="/">
                <img src="{{ asset('logo/Bex-principal.png') }}" alt="" class="w-56">
            </a>
        </x-slot>

        <!-- Session Status -->
        <!--suppress CheckEmptyScriptTag -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <!--suppress CheckEmptyScriptTag -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <!--suppress CheckEmptyScriptTag -->
                <x-input id="email" label="Email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <!-- Password -->
            <div class="mt-4">
                  <!--suppress CheckEmptyScriptTag -->
                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                label="Senha"
                                required autocomplete="current-password" />
            </div>



            <div class="flex flex-col items-center justify-center mt-2">
                <!-- Remember Me -->
                <div class="block mt-5">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <x-button class="rounded-full w-full py-3 mb-2">
                    {{ __('Entrar') }}
                </x-button>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
