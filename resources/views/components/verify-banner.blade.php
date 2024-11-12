<style>
    /* Email Verification Notification Styles */
    .email-verification-banner {
        background-color: #fff3cd;
        border-bottom: 1px solid #ffeeba;
        padding: 15px 0;
        text-align: center;
        font-size: 0.95rem;
    }

    .email-verification-banner .verification-actions {
        margin-top: 10px;
    }

    .email-verification-banner .resend-link {
        color: #007bff;
        cursor: pointer;
        text-decoration: underline;
        margin-left: 5px;
    }

    .email-verification-banner .verification-sent-message {
        color: #28a745;
        margin-top: 10px;
    }
</style>

@auth
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
            !auth()->user()->hasVerifiedEmail())
        <div class="email-verification-banner">
            <div class="container">
                <strong>{{ __('Please verify your email address') }} — {{ auth()->user()->email }}</strong>
                <p class="mb-0">
                    {{ __('Please verify your email using the link we sent you.') }}

                <form method="POST" action="{{ route('verification.send') }}" class="d-inline" id="verification-resend-form">
                    @csrf
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('verification-resend-form').submit();"
                        class="resend-link">
                        {{ __('Click here to resend email') }}
                    </a>
                </form>
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="verification-sent-message">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
@endauth
