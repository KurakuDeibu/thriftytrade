<x-guest-layout>
    <div class="register-container">
        <div class="register-wrapper">
            <!-- Image Section -->
            <div class="register-image">
                <div>
                </div>
            </div>

            <!-- Forgot Password Form Section -->
            <div class="register-form">
                <div class="form-content">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/thriftytrade-logo.png') }}" alt="Logo" class="logo">
                    </a>
                    <h2 class="mb-2 text-2xl text-center fw-bold">Forgot Password</h2>
                    <p class="mb-4 text-center text-gray-600">Enter your email to reset your password</p>

                    @if (session('status'))
                        <div class="mb-4 text-center alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4">
                            <div class="input-group">
                                <span class="text-white border-0 input-group-text bg-primary">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                            </div>
                            @error('email')
                                <div class="text-sm error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="register-button">
                            Send Password Reset Link
                        </button>
                    </form>

                    <div class="form-footer">
                        <p class="text-center text-gray-600">
                            Remember your password?
                            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                                Login here
                            </a>
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

    <style>
        /* Reuse the styles from the register page */
        :root {
            --primary-color: #4267B2;
            --secondary-color: #365899;
            --background-light: #f4f4f4;
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

        .image-overlay s {
            background: rgba(0, 0, 0, 0.5);
            padding: 2rem;
            border-radius: 16px;
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

        .register-button:hover {
            background: var(--secondary-color);
        }

        .error-message {
            color: #dc3545;
            margin-top: 0.2rem;
        }

        .form-footer {
            text-align: center;
            margin-top: 1rem;
        }

        /* Mobile Responsiveness */
        @media screen and (max-width: 768px) {
            .register-wrapper {
                flex-direction: column;
            }

            .register-image {
                display: none;
            }

            .register-form {
                padding: 1rem;
            }
        }
    </style>
</x-guest-layout>
