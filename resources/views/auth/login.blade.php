<x-guest-layout>
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

        .error-message {
            color: #dc3545;
            margin-top: 0.2rem;
        }

        .form-checkbox {
            border-radius: 4px;
            color: var(--primary-color);
            focus: ring-blue-500;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            background-color: var(--background-light);
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .login-image {
            flex: 1;
            background: linear-gradient(rgba(255, 255, 255, 0.323), rgba(72, 85, 231, 0.427)),
                url('{{ asset('img/TT-COVER.png') }}');
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

        .login-form {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .form-content {
            width: 100%;
            max-width: 400px;
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

        .form-input.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(66, 103, 178, 0.2);
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: var(--secondary-color);
        }

        .form-footer {
            text-align: center;
            margin-top: 1rem;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-wrapper {
                flex-direction: column;
            }

            .login-image {
                display: none;
                /* Optional: hide image on mobile */
            }

            .login-form {
                padding: 1rem;
            }

            .form-content {
                width: 100%;
                max-width: 100%;
            }

            .logo {
                width: 100px;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-wrapper">
            <!-- Image Section -->
            <div class="login-image">
                {{-- MESSAGE --}}
            </div>

            <!-- Login Form Section -->
            <div class="login-form">
                <div class="form-content">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/thriftytrade-logo.png') }}" alt="Logo" class="logo">
                    </a>
                    <h2 class="mb-2 text-2xl text-center fw-bold">Welcome Back</h2>
                    <p class="mb-4 text-center text-gray-600">Login to your account</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <input type="email" name="email" class="form-input @error('email') error @enderror"
                                placeholder="Email address" value="{{ old('email') }}" autofocus>
                            @error('email')
                                <div class="text-sm error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-input @error('password') error @enderror"
                                placeholder="Password">
                            @error('password')
                                <div class="text-sm error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <label class="flex items-center cursor-pointer">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="text-sm text-gray-600"> Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-indigo-600 hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="login-button">
                            Log In
                        </button>

                        <div class="mt-4 form-footer">
                            <p class="text-gray-600">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-indigo-600 text-decoration-none">
                                    Sign up
                                </a>
                                |
                                <a href="{{ route('home') }}" class="text-indigo-600 text-decoration-none">
                                    Home
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
