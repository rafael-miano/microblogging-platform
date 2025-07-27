<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ isLoading: false }" @submit="isLoading = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-4">
            <x-primary-button type="submit"
                class="block w-full justify-center px-3 py-2 rounded-md bg-[#1875FF] text-white text-sm font-medium shadow-[0px_4px_15px_-4px_#1875FF] transition-all duration-300
            hover:bg-[#1669e8] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1875FF] disabled:opacity-50"
                x-bind:disabled="isLoading">

                <span x-show="!isLoading" x-cloak>{{ __('Log in') }}</span>

                <span x-show="isLoading" x-cloak class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2
                        5.291A7.962 7.962 0 014 12H0c0
                        3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </svg>
                    {{ __('Logging in...') }}
                </span>
            </x-primary-button>
        </div>

        <!-- Register Prompt -->
        <div class="mt-4">
            <span class="text-[14px]">Don't have an account? Register</span>
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('here') }}
                </a>
            @endif
        </div>
    </form>

</x-guest-layout>
