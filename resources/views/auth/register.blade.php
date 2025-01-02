<x-guest-layout>


    <div class="register-container">
        <div class="register-wrapper">
            <!-- Image Section -->
            <div class="register-image">
            </div>

            <!-- Register Form Section -->
            <div class="register-form">
                <div class="form-content">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/thriftytrade-logo.png') }}" alt="Logo" class="logo">
                    </a>
                    <h2 class="mb-2 text-2xl text-center fw-bold">Create Your Account</h2>
                    <p class="mb-4 text-center text-gray-600">Join our community today</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3 name-row">
                            <div>
                                <label for="firstName" class="block mb-1 text-sm font-medium text-gray-700">First
                                    Name</label>
                                <input type="text" id="firstName" name="firstName"
                                    class="form-input @error('firstName') error @enderror"
                                    value="{{ old('firstName') }}">
                                @error('firstName')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="middleName" class="block mb-1 text-sm font-medium text-gray-700">Last
                                    Name</label>
                                <input type="text" id="middleName" name="middleName"
                                    class="form-input @error('middleName') error @enderror"
                                    value="{{ old('middleName') }}">
                                @error('middleName')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="lastName" class="block mb-1 text-sm font-medium text-gray-700">Last
                                    Name</label>
                                <input type="text" id="lastName" name="lastName"
                                    class="form-input @error('lastName') error @enderror" value="{{ old('lastName') }}">
                                @error('lastName')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 name-row">
                            <div>
                                <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Username
                                </label>
                                <input type="name" id="name" name="name"
                                    class="form-input @error('name') error @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email
                                    Address</label>
                                <input type="email" id="email" name="email"
                                    class="form-input @error('email') error @enderror" value="{{ old('email') }}">
                                @error('email')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 name-row">
                            <div>
                                <label for="birthDay" class="block mb-1 text-sm font-medium text-gray-700">Date of
                                    Birth</label>
                                <input type="date" id="birthDay" name="birthDay"
                                    class="form-input @error('birthDay') error @enderror"
                                    value="{{ old('birthDay') }}">
                                @error('birthDay')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="phoneNum" class="block mb-1 text-sm font-medium text-gray-700">Phone
                                    Number</label>
                                <input type="tel" id="phoneNum" name="phoneNum"
                                    class="form-input @error('phoneNum') error @enderror"
                                    value="{{ old('phoneNum') }}">
                                @error('phoneNum')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 form-group">
                            <label for="userAddress"
                                class="block mb-1 text-sm font-medium text-gray-700">Address</label>
                            <input type="text" id="userAddress" name="userAddress"
                                class="form-input @error('userAddress') error @enderror"
                                value="{{ old('userAddress') }}">
                            @error('userAddress')
                                <div class="text-sm error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 name-row">
                            <div class="relative form-group">
                                <input type="password" name="password" id="password"
                                    class="form-input @error('password') error @enderror" required
                                    autocomplete="new-password" placeholder="Password">
                                <i class="fas fa-eye-slash password-toggle" onclick="togglePassword('password')"></i>
                                @error('password')
                                    <div class="text-sm error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="relative form-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-input" required autocomplete="new-password"
                                    placeholder="Confirm Password">
                                <i class="fas fa-eye-slash password-toggle"
                                    onclick="togglePassword('password_confirmation')"></i>
                            </div>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="flex items-center mb-2 text-sm">
                                <input type="checkbox" id="terms" name="terms">
                                <label for="terms" class="ml-2 text-gray-600">
                                    &nbsp I agree to the <a href="{{ route('terms.show') }}"
                                        class="text-sm text-indigo-600 hover:underline">Terms of Service</a> and <a
                                        href="{{ route('policy.show') }}"
                                        class="text-sm text-indigo-600 hover:underline">Privacy Policy</a>
                                </label>
                            </div>
                            @error('terms')
                                <small class="text-sm error-message">{{ $message }}</small>
                            @enderror
                        @endif

                        <button type="submit" class="register-button">Register</button>
                    </form>

                    <div class="form-footer">
                        <p class="text-gray-600">Already have an account? <a href="{{ route('login') }}"
                                class="text-indigo-600 hover:underline">Login here</a>
                            |
                            <a href="{{ route('home') }}" class="text-indigo-600 text-decoration-none">
                                Home
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const icon = passwordInput.nextElementSibling;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>


    <style>
        :root {
            --primary-color: #4267B2;
            --secondary-color: #365899;
            --background-light: #f4f4f4;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            background-color: var(--background-light);
        }

        .form-input.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
        }

        .register-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }


        .register-wrapper {
            width: 100%;
            margin: 0 auto;
            display: flex;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            overflow: hidden;

        }

        .register-image {
            flex: 1;
            min-width: 40%;
            max-width: 45%;
            background: linear-gradient(rgba(255, 255, 255, 0), rgba(3, 22, 236, 0.423)),
                url('{{ asset('img/TT-COVER' . rand(1, 4) . '.png') }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .register-form {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .form-content {
            width: 100%;
            max-width: 500px;
        }

        .logo {
            width: fit-content;
            margin-bottom: 1.5rem;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(66, 103, 178, 0.2);
        }

        .register-button {
            width: 100%;
            padding: 12px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-footer {
            text-align: center;
            margin-top: 1rem;
        }

        .error-message {
            color: #dc3545;
            margin-top: 0.2rem;
        }

        .name-row {
            display: flex;
            gap: 1rem;
        }

        .name-row>div {
            flex: 1;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .register-wrapper {
                flex-direction: column;
            }

            .register-image {
                display: none;
            }

            .register-form {
                padding: 1rem;
            }

            .form-content {
                width: 100%;
                max-width: 100%;
            }

            .name-row {
                flex-direction: column;
                gap: 1rem;
            }

            .logo {
                width: 100px;
            }
        }
    </style>
</x-guest-layout>
