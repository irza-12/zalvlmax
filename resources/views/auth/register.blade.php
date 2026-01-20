<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-secondary-700 font-medium mb-1.5" />
            <x-text-input id="name" class="block w-full" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-secondary-700 font-medium mb-1.5" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" placeholder="john@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-secondary-700 font-medium mb-1.5" />
            <x-text-input id="password" class="block w-full" type="password" name="password" required
                autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                class="text-secondary-700 font-medium mb-1.5" />
            <x-text-input id="password_confirmation" class="block w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4 space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Create Account') }}
            </x-primary-button>

            <div class="text-center">
                <a class="text-sm font-medium text-secondary-500 hover:text-brand-600 transition-colors"
                    href="{{ route('login') }}">
                    {{ __('Already have an account? Sign In') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>