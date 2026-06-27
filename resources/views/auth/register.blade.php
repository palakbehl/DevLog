<x-guest-layout>
    <!-- Welcome Header -->
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-gray-900 dark:text-zinc-50">Create Account</h2>
        <p class="text-xs text-gray-500 mt-1 dark:text-zinc-400">Get started with your developer diary</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <x-form-input 
            type="text" 
            name="name" 
            label="Name" 
            :value="old('name')" 
            placeholder="John Doe" 
            required 
            autofocus 
            autocomplete="name" 
        />

        <!-- Email Address -->
        <x-form-input 
            type="email" 
            name="email" 
            label="Email Address" 
            :value="old('email')" 
            placeholder="you@example.com" 
            required 
            autocomplete="username" 
        />

        <!-- Password -->
        <x-form-input 
            type="password" 
            name="password" 
            label="Password" 
            placeholder="••••••••" 
            required 
            autocomplete="new-password" 
        />

        <!-- Confirm Password -->
        <x-form-input 
            type="password" 
            name="password_confirmation" 
            label="Confirm Password" 
            placeholder="••••••••" 
            required 
            autocomplete="new-password" 
        />

        <!-- Role Selection -->
        <div class="space-y-1.5 w-full">
            <label for="role" class="block text-sm font-semibold text-gray-700 dark:text-zinc-300">
                Register As <span class="text-red-500">*</span>
            </label>
            <select name="role" id="role" class="block w-full px-3.5 py-2.5 bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-700 rounded-lg shadow-xs text-sm text-gray-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 cursor-pointer">
                <option value="author">Author (Create & manage your own content)</option>
                <option value="admin">Admin (Manage all content)</option>
            </select>
            @error('role')
                <p class="text-xs font-medium text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit & Actions -->
        <x-button variant="primary" class="w-full py-3 mt-2 cursor-pointer">
            Create Account
        </x-button>

        <!-- Login Page Link -->
        <div class="text-center mt-4">
            <p class="text-xs font-medium text-gray-500 dark:text-zinc-400">
                Already registered? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                    Sign In
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
