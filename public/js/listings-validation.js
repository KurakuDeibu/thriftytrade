// listings-validation.js

document.addEventListener('DOMContentLoaded', function() {
    // Get all form inputs and selects
    const formInputs = document.querySelectorAll('.form-control, .form-select');

    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            validateField(this);
        });

        input.addEventListener('change', function() {
            validateField(this);
        });
    });

    function validateField(field) {
        // Remove any existing validation classes
        field.classList.remove('is-valid', 'is-invalid');

        // Check if the field has a value
        if (field.value.trim() !== '') {
            // Special validation for different field types
            switch(field.type) {
                case 'number':
                    if (parseFloat(field.value) >= 0) {
                        field.classList.add('is-valid');
                    }
                    break;

                case 'file':
                    if (field.files && field.files[0]) {
                        field.classList.add('is-valid');
                    }
                    break;

                case 'select-one':
                    if (field.value !== '') {
                        field.classList.add('is-valid');
                    }
                    break;

                case 'textarea':
                    if (field.value.trim().length >= 10) {
                        field.classList.add('is-valid');
                    }
                    break;

                default:
                    if (field.value.trim().length >= 3) {
                        field.classList.add('is-valid');
                    }
            }
        }
    }

    // Initial validation for pre-filled fields
    formInputs.forEach(input => {
        validateField(input);
    });
});
