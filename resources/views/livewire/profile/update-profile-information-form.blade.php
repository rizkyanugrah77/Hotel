<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $gender = '';
    public string $nationality = '';
    public $avatar;
    public string $currentAvatar = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone ?? '';
        $this->address = Auth::user()->address ?? '';
        $this->gender = Auth::user()->gender ?? '';
        $this->nationality = Auth::user()->nationality ?? '';
        $this->currentAvatar = Auth::user()->avatar ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'regex:/^(?:\+62|08)[0-9]{8,12}$/', Rule::unique(User::class)->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'avatar' => ['nullable', 'image', 'max:10240'],
            'nationality' => ['nullable', 'string', 'max:255'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($this->avatar) {
            $imageName = Str::uuid() . '.' . $this->avatar->getClientOriginalExtension();
            $this->avatar->storeAs('assets/img/user', $imageName, 'public');
            $user->avatar = $imageName;
            $this->currentAvatar = $imageName;
            $this->reset('avatar');
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    @php
        $profileInitials = collect(explode(' ', trim($name)))
            ->filter()
            ->map(fn($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    @endphp

    <header class="flex items-start gap-4 sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Profile Information') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </div>

        <div class="shrink-0 sm:hidden">
            @if ($currentAvatar)
                <img src="{{ asset('storage/assets/img/user/' . $currentAvatar) }}" alt="Foto profil {{ $name }}"
                    class="h-12 w-12 rounded-full object-cover ring-2 ring-primary/20">
            @else
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-primary text-sm font-bold text-white"
                    aria-hidden="true">
                    {{ $profileInitials ?: 'UP' }}
                </div>
            @endif
        </div>
    </header>

    <form wire:submit.prevent="updateProfileInformation" class="mt-5 space-y-5">
        <div
            class="rounded-xl border border-gray-100 bg-gray-50 p-4 sm:flex sm:items-center sm:justify-between sm:gap-5">
            <div class="flex min-w-0 items-center gap-3">
                <div class="hidden shrink-0 sm:block">
                    @if ($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" alt="Pratinjau foto profil"
                            class="h-16 w-16 rounded-full object-cover ring-2 ring-primary/20">
                    @elseif ($currentAvatar)
                        <img src="{{ asset('storage/assets/img/user/' . $currentAvatar) }}"
                            alt="Foto profil {{ $name }}"
                            class="h-16 w-16 rounded-full object-cover ring-2 ring-primary/20">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-primary text-lg font-bold text-white"
                            aria-hidden="true">
                            {{ $profileInitials ?: 'UP' }}
                        </div>
                    @endif
                </div>
                <div class="min-w-0">
                    <div class="inline-flex gap-2">
                        <x-input-label for="avatar" :value="__('Foto Profil')" />
                        <span class="text-xs text-red-500">*</span>
                    </div>
                    <p class="mt-0.5 text-xs text-gray-500">JPG, PNG, atau WEBP, maksimal 10 MB.</p>
                    <p wire:loading wire:target="avatar" class="mt-1 text-xs font-medium text-primary">Menyiapkan
                        pratinjau foto...</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-0 sm:w-64">
                <x-text-input wire:model.live="avatar" id="avatar" name="avatar" type="file" accept="image/*"
                    class="input text-sm mt-1 block w-full" required autocomplete="photo" />
                <x-input-error class="mt-2" :message="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <div class="inline-flex gap-2">
                    <x-input-label for="name" :value="__('Name')" />
                    <span class="text-xs text-red-500">*</span>
                </div>
                <x-text-input wire:model="name" id="name" name="name" type="text"
                    class="input text-sm mt-1 block w-full" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :message="$errors->get('name')" />
            </div>

            <div>
                <div class="inline-flex gap-2">
                    <x-input-label for="email" :value="__('Email')" />
                    <span class="text-xs text-red-500">*</span>
                </div>
                <x-text-input wire:model="email" id="email" name="email" type="email"
                    class="input text-sm mt-1 block w-full" required autocomplete="username" />
                <x-input-error class="mt-2" :message="$errors->get('email')" />

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div>
                        <p class="mt-2 text-sm text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button type="button" wire:click.prevent="sendVerification"
                                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <div class="inline-flex gap-2">
                    <x-input-label for="phone" :value="__('Phone')" />
                    <span class="text-xs text-red-500">*</span>
                </div>

                <x-text-input wire:model="phone" id="phone" name="phone" type="tel"
                    class="input text-sm mt-1 block w-full" autocomplete="tel" required
                    placeholder="+62/08-1234567890" />
                <x-input-error class="mt-2" :message="$errors->get('phone')" />
            </div>

            <div>
                <div class="inline-flex gap-2">
                    <x-input-label for="nationality" :value="__('Nationality')" />
                    <span class="text-xs text-red-500">*</span>
                </div>
                <select wire:model="nationality" id="nationality" name="nationality" required
                    class="input text-sm mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="">Select Nationality</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Malaysia">Malaysia</option>
                    <option value="Singapore">Singapore</option>
                    <option value="Thailand">Thailand</option>
                    <option value="Vietnam">Vietnam</option>
                    <option value="Philippines">Philippines</option>
                    <option value="Other">Other</option>
                </select>
                <x-input-error class="mt-2" :message="$errors->get('nationality')" />
            </div>

            <div class="sm:col-span-2">
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input wire:model="address" id="address" name="address" type="text"
                    class="mt-1 block w-full" autocomplete="street-address" placeholder="Enter your address" />
                <x-input-error class="mt-2" :message="$errors->get('address')" />
            </div>

            <div>
                <div class="inline-flex gap-2">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <span class="text-xs text-red-500">*</span>
                </div>
                <select wire:model="gender" id="gender" name="gender" required
                    class="input text-sm mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <x-input-error class="mt-2" :message="$errors->get('gender')" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-3 border-t border-gray-100 pt-4">
            <x-action-message class="text-sm" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>

            <x-primary-button class="min-h-11 px-5">{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
