<x-guest-layout>
    <!-- Welcome Header -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-zinc-50">Welcome Back</h2>
        <p class="text-xs text-gray-500 mt-1 dark:text-zinc-400">Please enter your details to sign in</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <x-form-input 
            type="email" 
            name="email" 
            label="Email" 
            :value="old('email')" 
            placeholder="you@example.com" 
            required 
            autofocus 
            autocomplete="username" 
        />

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex justify-between items-center">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">
                    Password <span class="text-red-500">*</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input 
                type="password" 
                name="password" 
                id="password" 
                required 
                autocomplete="current-password" 
                class="block w-full px-3.5 py-2.5 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg shadow-xs text-sm text-gray-900 dark:text-zinc-100 placeholder-gray-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
            >
            @error('password')
                <p class="text-xs font-medium text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="w-4.5 h-4.5 text-indigo-600 border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 rounded-sm focus:ring-indigo-500 focus:ring-2 cursor-pointer">
            <label for="remember_me" class="ml-2.5 text-sm font-semibold text-gray-600 dark:text-zinc-400 cursor-pointer">Remember me</label>
        </div>

        <!-- Submit & Actions -->
        <x-button variant="primary" class="w-full py-3 mt-2 cursor-pointer">
            Sign In
        </x-button>

        <!-- Register Page Link -->
        <div class="text-center mt-4">
            <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                    Sign Up
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
