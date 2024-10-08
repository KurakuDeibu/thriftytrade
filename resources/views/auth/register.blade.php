<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            {{-- <x-authentication-card-logo /> --}}
            <h1 class="py-2 font-extrabold text-indigo-600 display-5">REGISTRATION</h1>
        </x-slot>

        {{-- <x-validation-errors class="mb-4" /> --}}

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="firstName" value="{{ __('First Name') }}" />
                <x-input id="firstName" class="block w-full mt-1" type="text" name="firstName" :value="old('firstName')" autofocus autocomplete="firstName" />
                @error('firstName')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror

                <x-label for="middleName" value="{{ __('Middle Name') }}" />
                <x-input id="middleName" class="block w-full mt-1" type="text" name="middleName" :value="old('middleName')" autofocus autocomplete="middleName" />
                @error('middleName')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror

                <x-label for="lastName" value="{{ __('Last Name') }}" />
                <x-input id="lastName" class="block w-full mt-1" type="text" name="lastName" :value="old('lastName')" autofocus autocomplete="lastName" />
                @error('lastName')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror                
            </div>

            <div class="mt-4">
                <x-label for="name" value="{{ __('Username') }}" />
                <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" autocomplete="name" />
                @error('name')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror

                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" autocomplete="email" />
                @error('email')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="birthDay" value="{{ __('Birth Date') }}" />
                <x-input id="birthDay" class="block w-full mt-1" type="date" name="birthDay" :value="old('birthDay')" autocomplete="birthDay" />
                @error('birthDay')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror

                <x-label for="userAddress" value="{{ __('Address') }}" />
                <x-input id="userAddress" class="block w-full mt-1" type="text" name="userAddress" :value="old('userAddress')" autocomplete="userAddress" />
                @error('userAddress')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror

                <x-label for="phoneNum" value="{{ __('Phone Number') }}" />
                <x-input id="phoneNum" class="block w-full mt-1" type="tel" name="phoneNum" :value="old('phoneNum')" autocomplete="phoneNum" />
                @error('phoneNum')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block w-full mt-1" type="password" name="password" autocomplete="new-password" />
                @error('password')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" autocomplete="new-password" />
                @error('password_confirmation')
                    <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                @enderror
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                    @error('terms')
                        <small class="mt-1 text-xsm text-red-600 font-semibold">{{$message}}</small>
                    @enderror
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
