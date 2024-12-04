<!-- In transactions/index.blade.php or a partial view -->
<div class="modal fade" id="transactionConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <strong>Important:</strong> By completing this transaction, the product will be marked as sold,
                    and the system will calculate commissions.
                </div>
                <div class="transaction-details">
                    <!-- Dynamic transaction details will be populated here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmTransactionBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>
