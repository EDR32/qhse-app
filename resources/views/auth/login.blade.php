<x-guest-layout>
    <div class="flex justify-center">
        {{-- Placeholder for a more prominent logo --}}
        <img class="h-16 w-auto" src="https://bcs-logistics.co.id/assets/images/logoo.png" alt="BCS Logistics">
    </div>
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Selamat Datang Kembali!
    </h2>
    <p class="mt-2 text-center text-sm text-gray-600">
        Masuk ke akun Anda
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a class="font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                </div>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
