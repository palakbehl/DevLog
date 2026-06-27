<x-app-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-zinc-50 tracking-tight">Profile Settings</h1>
            <p class="text-sm text-gray-500 mt-1 dark:text-zinc-400">Manage your account information, update security settings, or delete your account.</p>
        </div>

        <!-- Cards -->
        <div class="space-y-6">
            <x-card>
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </x-card>

            <x-card>
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </x-card>

            <x-card>
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
