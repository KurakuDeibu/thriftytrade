{{-- components/alerts.blade.php --}}

{{-- Success Message --}}
@if (session('success'))
    <x-alert-toast type="success" :message="session('success')" />
@endif

{{-- Error Messages --}}
@if (session('error'))
    <x-alert-toast type="error" :message="session('error')" />
@endif

{{-- Warning Messages --}}
@if (session('warning'))
    <x-alert-toast type="warning" :message="session('warning')" />
@endif

{{-- Info Messages --}}
@if (session('info'))
    <x-alert-toast type="info" :message="session('info')" />
@endif

{{-- Primary Messages --}}
@if (session('primary'))
    <x-alert-toast type="primary" :message="session('primary')" />
@endif

{{-- Secondary Messages --}}
@if (session('secondary'))
    <x-alert-toast type="secondary" :message="session('secondary')" />
@endif

{{-- Dark Messages --}}
@if (session('dark'))
    <x-alert-toast type="dark" :message="session('dark')" />
@endif

{{-- Light Messages --}}
@if (session('light'))
    <x-alert-toast type="light" :message="session('light')" />
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <x-alert-toast type="error" :message="$error" />
    @endforeach
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showAlert(alertElement) {
                if (alertElement) {
                    // Get custom duration or default to 5000ms
                    const duration = parseInt(alertElement.dataset.duration) || 5000;

                    // Show the alert
                    setTimeout(() => {
                        alertElement.style.transform = 'translateX(0)';
                    }, 100);

                    // Auto hide after duration
                    setTimeout(() => {
                        hideAlert(alertElement);
                    }, duration);

                    // Close button functionality
                    const closeButton = alertElement.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.addEventListener('click', () => {
                            hideAlert(alertElement);
                        });
                    }
                }
            }

            function hideAlert(alertElement) {
                alertElement.style.transform = 'translateX(100%)';
                alertElement.addEventListener('transitionend', () => {
                    alertElement.remove();
                }, {
                    once: true
                });
            }

            // Get all alerts
            const alerts = document.querySelectorAll('[id$="Alert"]');

            // Show each alert with a slight delay between them
            alerts.forEach((alert, index) => {
                setTimeout(() => {
                    showAlert(alert);
                }, index * 300);
            });
        });
    </script>
@endpush
