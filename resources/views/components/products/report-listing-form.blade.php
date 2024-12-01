@auth
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content report-modal-content">
                <div class="modal-header report-modal-header">
                    <h5 class="modal-title" id="reportModalLabel">
                        <i class="fas fa-flag text-danger me-2"></i>
                        @if (request()->routeIs('profile.user-listing'))
                            Report User
                        @else
                            Report Listing
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form
                    @if (request()->routeIs('profile.user-listing')) action="{{ route('user.report', $user->id) }}"
                @else
                    action="{{ route('product.report', $marketplaceProducts->id) }}" @endif
                    method="POST">
                    @csrf
                    <input type="hidden" name="report_type"
                        value="{{ request()->routeIs('profile.user-listing') ? 'user' : 'product' }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reason" class="form-label fw-bold">Reason for Reporting</label>
                            @php
                                $reasons = request()->routeIs('profile.user-listing')
                                    ? [
                                        '' => 'Select a Reason',
                                        'harassment' => 'Harassment',
                                        'inappropriate' => 'Inappropriate Behavior',
                                        'fraud' => 'Fraudulent Activity',
                                        'impersonation' => 'Impersonation',
                                        'spam' => 'Spam or Scam',
                                        'offensive' => 'Offensive Content',
                                        'privacy' => 'Privacy Violation',
                                        'malicious' => 'Malicious Behavior',
                                        'fake_profile' => 'Fake Profile',
                                        'other' => 'Other',
                                    ]
                                    : [
                                        '' => 'Select a Reason',
                                        'inappropriate' => 'Inappropriate Content',
                                        'fraud' => 'Fraudulent Listing',
                                        'spam' => 'Spam or Scam',
                                        'misleading' => 'Misleading Information',
                                        'duplicate' => 'Duplicate Listing',
                                        'prohibited' => 'Prohibited Item',
                                        'condition' => 'Misrepresented Condition',
                                        'copyright' => 'Copyright Infringement',
                                        'safety' => 'Safety Concern',
                                        'other' => 'Other',
                                    ];
                            @endphp
                            <select name="reason" id="reason" class="form-select">
                                @foreach ($reasons as $value => $label)
                                    <option value="{{ $value }}"
                                        @if ($value === '') selected disabled @endif>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="otherReasonContainer" style="display: none;">
                            <label for="other_reason" class="form-label">Specify Other Reason</label>
                            <input type="text" name="other_reason" id="other_reason" class="form-control"
                                placeholder="Please provide more details">
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label">Additional Details</label>
                            <textarea name="details" id="details" class="form-control" rows="4"
                                placeholder="Please provide more information about your report"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-paper-plane me-2"></i> Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endauth

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const reasonSelect = document.getElementById('reason');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        const otherReasonInput = document.getElementById('other_reason');

        reasonSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherReasonContainer.style.display = 'block';
                otherReasonInput.required = true;
            } else {
                otherReasonContainer.style.display = 'none';
                otherReasonInput.required = false;
                otherReasonInput.value = '';
            }
        });
    });
</script>

<style>
    .report-modal-content {
        border-radius: 10px;
    }

    .report-modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .form-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .75rem center;
        background-size: 8px 10px;
    }

    .form-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }
</style>
