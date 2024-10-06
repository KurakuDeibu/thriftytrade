<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>



    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-6">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="object-cover w-20 h-20 border-b-2 rounded-full">

                        {{-- SHOW IF USER IS VERIFIED OR NOT --}}
                    @if ($this->user->hasVerifiedEmail())
                    <span class="ml-2 text-green-600">
                        <i class="fas fa-check-circle"></i> {{ __('Verified') }}
                    </span>
                    @else
                    <span class="ml-2 text-red-600">
                        <i class="fas fa-times-circle"></i> {{ __('Not Verified') }}
                    </span>
                    @endif

                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- First Name -->
        <div class="col-span-3 sm:col-span-2">
            <x-label for="firstName" value="{{ __('First Name') }}" />
            <x-input id="firstName" type="text" class="block w-full mt-1" wire:model="state.firstName" required autocomplete="firstName" />
            <x-input-error for="firstName" class="mt-2" />
        </div>

         <!-- Middle Name -->
         <div class="col-span-3 sm:col-span-2">
            <x-label for="middleName" value="{{ __('Middle Name') }}" />
            <x-input id="middleName" type="text" class="block w-full mt-1" wire:model="state.middleName" autocomplete="middleName" />
            <x-input-error for="middleName" class="mt-2" />
        </div>

         <!-- Last Name -->
         <div class="col-span-3 sm:col-span-2">
            <x-label for="lastName" value="{{ __('Last Name') }}" />
            <x-input id="lastName" type="text" class="block w-full mt-1" wire:model="state.lastName" required autocomplete="lastName" />
            <x-input-error for="lastName" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="col-span-3 sm:col-span-2">
            <x-label for="name" value="{{ __('Username') }}" />
            <x-input id="name" type="text" class="block w-full mt-1" wire:model="state.name" required autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- User Address -->
        <div class="col-span-6">
            <x-label for="userAddress" value="{{ __('Address') }}" />
            <x-input id="userAddress" type="text" class="block w-full mt-1" wire:model="state.userAddress" required autocomplete="userAddress" />
            <x-input-error for="userAddress" class="mt-2" />
        </div>

        <!-- BirthDate -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="birthDay" value="{{ __('Birth Date') }}" />
            <x-input id="birthDay" type="date" class="block w-full mt-1" wire:model="state.birthDay" required autocomplete="birthDay" />
            <x-input-error for="birthDay" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="col-span-6 sm:col-span-3">
            <x-label for="phoneNum" value="{{ __('Phone Number') }}" />
            <x-input id="phoneNum" type="tel" class="block w-full mt-1" wire:model="state.phoneNum" required autocomplete="phoneNum" />
            <x-input-error for="phoneNum" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 md:col-span-6">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="block w-full mt-1" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="mt-2 text-sm">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm font-medium text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Profile Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
