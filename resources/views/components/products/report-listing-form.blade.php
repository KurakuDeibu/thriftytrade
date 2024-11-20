@auth
    @if (Auth::user()->id != $marketplaceProducts->author->id)
        <!-- Report Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content report-modal-content">
                    <div class="modal-header report-modal-header">
                        <h5 class="modal-title" id="reportModalLabel">
                            <i class="fas fa-flag text-danger me-2"></i>Report this listing
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="reportProductForm" action="{{ route('product.report', $marketplaceProducts->id) }}"
                            method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="reportReason" class="form-label fw-bold">Reason for
                                    Reporting</label>
                                <div class="report-reason-grid">
                                    @php
                                        $reasons = [
                                            'inappropriate' => 'Inappropriate Content',
                                            'fraud' => 'Fraudulent Listing',
                                            'spam' => 'Spam or Scam',
                                            'misleading' => 'Misleading Information',
                                            'duplicate' => 'Duplicate Listing',
                                            'other' => 'Other',
                                        ];
                                    @endphp
                                    @foreach ($reasons as $value => $label)
                                        <div class="form-check report-reason-item">
                                            <input class="form-check-input" type="radio" name="reason"
                                                id="reason-{{ $value }}" value="{{ $value }}" required>
                                            <label class="form-check-label" for="reason-{{ $value }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="reportDetails" class="form-label fw-bold">Additional
                                    Details</label>
                                <textarea class="form-control" id="reportDetails" name="details" rows="4"
                                    placeholder="Please provide more information about your report (optional)"></textarea>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Your report will be reviewed by our moderation team
                                </small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('styles')
            <style>
                .report-modal-content {
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                }

                .report-modal-header {
                    background-color: #f8f9fa;
                    border-bottom: 1px solid #e9ecef;
                    padding: 1rem;
                }

                .report-reason-grid {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 10px;
                }

                .report-reason-item {
                    background-color: #f4f4f4;
                    border-radius: 8px;
                    padding: 10px;
                    transition: all 0.3s ease;
                }

                .report-reason-item:hover {
                    background-color: #e9ecef;
                }

                .report-reason-item input[type="radio"] {
                    margin-right: 10px;
                }

                @media (max-width: 768px) {
                    .report-reason-grid {
                        grid-template-columns: 1fr;
                    }
                }
            </style>
        @endpush
    @endif
@endauth
