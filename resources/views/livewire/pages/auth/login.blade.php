<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirect(route('index', absolute: true), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-5 text-center" :status="session('status')" />

    @if (session('error'))
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700 text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Heading -->
    <div class="text-center mb-7">
        <span class="badge-accent mb-2.5">{{ __('Sitio Tio Resort') }}</span>
        <h2 class="text-2xl sm:text-3xl font-poppins font-bold text-foreground">
            <span class="text-gradient-primary">{{ __('Welcome Back') }}</span>
        </h2>
        <div class="gold-line-center mt-2.5"></div>
        <p class="mt-3 text-sm text-gray-600 font-inter max-w-xs mx-auto">
            {{ __('Sign in to your account to continue your Lakeside escape') }}
        </p>
    </div>

    <form wire:submit="login" class="space-y-4">
        <!-- Email Address -->
        <div>
            <label for="email" class="input-label">{{ __('Email') }}</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <input wire:model="form.email" id="email" class="input !pl-12" type="email" name="email"
                    required autofocus autocomplete="username" placeholder="{{ __('your@email.com') }}" />
            </div>
            <x-input-error :message="$errors->get('form.email')" class="mt-1.5 block" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <label for="password" class="input-label">{{ __('Password') }}</label>
            <div class="relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
                <input wire:model="form.password" id="password" class="input !pl-12 !pr-11"
                    x-bind:type="show ? 'text' : 'password'" type="password" name="password"
                    required autocomplete="current-password" placeholder="{{ __('Enter your password') }}" />
                <button type="button" x-on:click="show = !show"
                    class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                    aria-label="{{ __('Toggle password visibility') }}">
                    <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :message="$errors->get('form.password')" class="mt-1.5 block" />
        </div>

        <!-- Remember Me + Forgot -->
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between pt-0.5">
            <label for="remember" class="inline-flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember"
                    class="rounded border-gray-300 text-primary focus:ring-primary" />
                {{ __('Remember me') }}
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate
                    class="text-sm font-medium text-primary hover:text-accent-700 transition-colors">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <div class="pt-1">
            <button type="submit" wire:loading.attr="disabled" class="btn-primary w-full !py-3.5 !text-base">
                <span wire:loading.remove wire:target="login" class="relative">{{ __('Login') }}</span>
                <span wire:loading wire:target="login" class="loading flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-6.219-8.56" />
                    </svg>
                    {{ __('Logging in...') }}
                </span>
            </button>
        </div>
    </form>

    <!-- Google Socialite Login -->
    <x-google-auth-button />

    <!-- Footer -->
    <div class="mt-6 pt-5 border-t border-gray-200/70 flex flex-col items-center gap-3 sm:flex-row sm:justify-between">
        <a href="/" wire:navigate
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75" />
            </svg>
            {{ __('Back to site') }}
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" wire:navigate
                class="text-sm text-gray-500 hover:text-primary transition-colors">
                {{ __("Don't have an account?") }}
                <span class="font-semibold text-primary">{{ __('Register') }}</span>
            </a>
        @endif
    </div>
</div>
