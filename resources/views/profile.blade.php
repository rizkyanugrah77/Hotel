<x-user-layout>
    <div class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 flex-shrink-0">
        <h1 class="text-xl font-poppins font-bold text-foreground">{{ __('Profile') }}</h1>
    </div>

    <main class="flex-1 overflow-y-auto p-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="card p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <livewire:profile.update-profile-information-form />
            </div>

            <div class="card p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <livewire:profile.update-password-form />
            </div>

            <div class="card p-6 sm:p-8 bg-white border border-gray-100 shadow-sm rounded-2xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </main>
</x-user-layout>
