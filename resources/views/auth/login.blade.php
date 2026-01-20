<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-secondary-700 font-medium mb-2" />
            <div class="relative">
                <x-text-input id="email" class="block w-full pl-4" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <x-input-label for="password" :value="__('Password')" class="text-secondary-700 font-medium" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-brand-600 hover:text-brand-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <div class="relative">
                <x-text-input id="password" class="block w-full pl-4" type="password" name="password" required
                    autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox"
                class="rounded-lg border-secondary-300 text-brand-600 shadow-sm focus:ring-brand-500 w-5 h-5 transition-all cursor-pointer"
                name="remember">
            <span class="ms-3 text-sm text-secondary-600 select-none cursor-pointer"
                onclick="document.getElementById('remember_me').click()">{{ __('Remember me on this device') }}</span>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Sign In to Your Account') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>