<style>
    .register-form {
        width: 100%;
        max-width: 600px;
        padding: 2rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }


    .register-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .progress {
        height: 4px;
        width: 100%;
        background-color: #e9ecef;
    }

    .user-type-option i {
        cursor: pointer;
        transition: all 0.3s;
    }

    .user-type-option:hover,
    .user-type-option.selected {
        background-color: #e7f3ff;
        border-color: #1877f2 !important;
    }

    .user-type-option i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
</style>

@extends('layouts.app')

@section('content')
    <div class="register-container">

        {{-- ONBOARDING CONTENT --}}
        <div class="register-form">
            <div class="card-body">
                <h1 class="text-center mb-4">Registration</h1>
                <div class="mb-2">
                    <ol class="list-unstyled d-flex justify-content-between align-items-center">
                        <li class="fw-bold text-primary position-relative">
                            1. Basic Info
                            <div class="progress mt-2" style="height: 4px; width: 100%;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </li>
                        <li class="fw-bold position-relative">
                            2. Additional Details
                            <div class="progress mt-2" style="height: 4px; width: 100%;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </li>
                        <li class="fw-bold position-relative">
                            3. User Type
                            <div class="progress mt-2" style="height: 4px; width: 100%;">
                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </li>
                    </ol>
                </div>
                <div class="progress-bar" role="progressbar" id="progress" style="width: 0%;" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>

            <form id="onboardingForm" action="{{ route('auth.onboard-register') }}" method="POST">
                @csrf

                <div id="step1" class="step">
                    <div class="mb-2">
                        <label for="userEmail" class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                        <input type="text" value="{{ old('userEmail') }}"
                            class="form-control {{ $errors->has('userEmail') ? 'is-invalid' : '' }}" id="userEmail"
                            name="userEmail">
                        <small class="text-danger">{{ $errors->first('userEmail') }}</small>
                    </div>

                    <div class="mb-2">
                        <label for="userPassword" class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                        <input type="password" class="form-control {{ $errors->has('userPassword') ? 'is-invalid' : '' }}"
                            id="userPassword" name="userPassword">
                        <small class="text-danger">{{ $errors->first('userPassword') }}</small>
                    </div>

                    <div class="mb-2">
                        <label for="userPassword_confirmation" class="form-label"><i class="fas fa-lock me-2"></i>Confirm
                            Password</label>
                        <input type="password"
                            class="form-control {{ $errors->has('userPassword_confirmation') ? 'is-invalid' : '' }}"
                            id="userPassword_confirmation" name="userPassword_confirmation">
                        <small class="text-danger">{{ $errors->first('userPassword_confirmation') }}</small>
                    </div>

                    <div class="mb-2">
                        <label for="userFName" class="form-label"><i class="fas fa-user me-2"></i>First Name</label>
                        <input type="text" value="{{ old('userFName') }}"
                            class="form-control {{ $errors->has('userFName') ? 'is-invalid' : '' }}" id="userFName"
                            name="userFName">
                        <small class="text-danger">{{ $errors->first('userFName') }}</small>
                    </div>

                    <div class="mb-2">
                        <label for="userLName" class="form-label"><i class="fas fa-user me-2"></i>Last Name</label>
                        <input type="text" value="{{ old('userLName') }}"
                            class="form-control {{ $errors->has('userLName') ? 'is-invalid' : '' }}" id="userLName"
                            name="userLName">
                        <small class="text-danger">{{ $errors->first('userLName') }}</small>
                    </div>
                </div>

                <div id="step2" class="step" style="display: none;">
                    <div class="mb-2">
                        <label for="userMName" class="form-label"><i class="fas fa-user me-2"></i>Middle Name
                            (Optional)</label>
                        <input type="text" value="{{ old('userMName') }}"
                            class="form-control {{ $errors->has('userLName') ? 'is-invalid' : '' }}" id="userMName"
                            name="userMName">
                    </div>

                    <div class="mb-2">
                        <label for="userAddress" class="form-label"><i
                                class="bi bi-geo-alt-fill me-2"></i>Address</label>
                        <input type="text" value="{{ old('userAddress') }}"
                            class="form-control {{ $errors->has('userAddress') ? 'is-invalid' : '' }}" id="userAddress"
                            name="userAddress">
                        <small class="text-danger">{{ $errors->first('userAddress') }}</small>
                    </div>

                    <div class="mb-2">
                        <label for="userBDay" class="form-label"><i
                                class="fas fa-birthday-cake me-2"></i>Birthday</label>
                        <input type="date" value="{{ old('userBDay') }}"
                            class="form-control {{ $errors->has('userBDay') ? 'is-invalid' : '' }}" id="userBDay"
                            name="userBDay">
                        <small class="text-danger">{{ $errors->first('userBDay') }}</small>
                    </div>

                    <div class="mb-2">
                        <label for="userPhoneNum" class="form-label"><i class="fas fa-phone me-2"></i>Phone
                            Number</label>
                        <input type="number" value="{{ old('userPhoneNum') }}"
                            class="form-control {{ $errors->has('userPhoneNum') ? 'is-invalid' : '' }}" id="userPhoneNum"
                            name="userPhoneNum">
                        <small class="text-danger">{{ $errors->first('userPhoneNum') }}</small>
                    </div>
                </div>

                <div id="step3" class="step" style="display: none;">
                    <h4 class="mb-4">How would you like to use ThriftyTrade?</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="user-type-option border rounded p-3 text-center"
                                onclick="selectUserType('seller')">
                                <i class="fas fa-store text-primary"></i>
                                <p class="mb-0">Seller</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="user-type-option border rounded p-3 text-center"
                                onclick="selectUserType('buyer')">
                                <i class="fas fa-shopping-cart text-success"></i>
                                <p class="mb-0">Buyer</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="user-type-option border rounded p-3 text-center"
                                onclick="selectUserType('finder')">
                                <i class="fas fa-search text-info"></i>
                                <p class="mb-0">Finder</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="termsAgree" required>
                        <label class="form-check-label" for="termsAgree">I agree to the <a href="/terms">Terms of
                                Service</a> and <a href="/privacy">Privacy Policy</a></label>
                        <small class="text-danger">{{ $errors->first('termsAgree') }}</small>
                    </div>

                    <input type="hidden" id="userType" name="userType" value="{{ old('userType') }}">
                    <small class="text-danger">{{ $errors->first('userType') }}</small>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" id="prevBtn" onclick="prevStep()"
                        style="display: none;"><i class="fas fa-arrow-left me-2"></i>Back</button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextStep()">Next<i
                            class="fas fa-arrow-right ms-3"></i></button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function updateProgressBar() {
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach((bar, index) => {
            if (index + 1 < currentStep) {
                bar.style.width = '100%';
                bar.classList.remove('bg-secondary');
                bar.classList.add('bg-primary');
            } else if (index + 1 === currentStep) {
                bar.style.width = '100%';
                bar.classList.remove('bg-secondary');
                bar.classList.add('bg-primary');
            } else {
                bar.style.width = '0%';
                bar.classList.remove('bg-primary');
                bar.classList.add('bg-secondary');
            }
        });

        const steps = document.querySelectorAll('ol li');
        steps.forEach((step, index) => {
            if (index + 1 <= currentStep) {
                step.classList.add('text-primary');
            } else {
                step.classList.remove('text-primary');
            }
        });
    }

    function showStep(step) {
        document.querySelectorAll('.step').forEach(s => s.style.display = 'none');
        document.getElementById(`step${step}`).style.display = 'block';
        document.getElementById('prevBtn').style.display = step > 1 ? 'inline-block' : 'none';
        document.getElementById('nextBtn').innerHTML = step === totalSteps ? 'Submit<i class="fas fa-check ms-2"></i>' :
            'Next<i class="fas fa-arrow-right ms-2"></i>';
    }

    function nextStep() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
                updateProgressBar();
            } else {
                document.getElementById('onboardingForm').submit();
            }
        }
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
            updateProgressBar();
        }
    }

    function validateStep(step) {
        let isValid = true;
        let fields = [];
        if (step === 1) {
            fields = ['userEmail', 'userPassword', 'userPassword_confirmation', 'userFName', 'userLName'];
        } else if (step === 2) {
            fields = ['userAddress', 'userBDay', 'userPhoneNum'];
        } else if (step === 3) {
            const userType = document.getElementById('userType').value;
            const termsAgree = document.getElementById('termsAgree').checked;
            if (!userType) {
                isValid = false;
                document.querySelectorAll('.user-type-option').forEach(option => {
                    option.classList.add('is-invalid');
                });
            } else {
                document.querySelectorAll('.user-type-option').forEach(option => {
                    option.classList.remove('is-invalid');
                });
            }
            if (!termsAgree) {
                isValid = false;
                document.getElementById('termsAgree').classList.add('is-invalid');
            } else {
                document.getElementById('termsAgree').classList.remove('is-invalid');
            }
        }

        fields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return isValid;
    }

    function selectUserType(type) {
        document.querySelectorAll('.user-type-option').forEach(option => {
            option.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
        document.getElementById('userType').value = type;
    }

    updateProgressBar();
    showStep(currentStep);
</script>
