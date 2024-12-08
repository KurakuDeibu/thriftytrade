@php
    $sellerName = $marketplaceProducts->author->name;
    $userId = auth()->user()->id;
    $receiverId = $marketplaceProducts->author->id;
    $productId = $marketplaceProducts->id;
@endphp

<!-- Button to trigger modal -->
<div class="mb-2 d-lg-block">
    <a href="#" class="shadow-sm btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#chatModal">
        <i class="fas fa-envelope me-2"></i> CHAT WITH SELLER
    </a>
</div>

<!-- Chat Modal -->
<div x-data=
    "{
        messages: '',
        successMessage: false,
        sendMessages() {
            axios.post('/send/messages', {
                    userId: {{ $userId }},
                    receiverId: {{ $receiverId }},
                    productId: {{ $productId }},
                    messages: this.messages
                })
                .then(response => {
                    this.messages = '';
                    this.successMessage = true;
                    setTimeout(() => this.successMessage = false, 3000); // Hide success message after 3 seconds
                })
                .catch(error => {
                    console.error('Error sending messages:', error);
                });
        }
    }"
    class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="border-0 shadow modal-content">
            <!-- Modal Header -->
            <div class="text-white bg-primary modal-header">
                <h5 class="modal-title" id="chatModalLabel">
                    <i class="fas fa-comments me-2"></i>
                    Chat with <span class="fw-bold">{{ $sellerName }}</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 modal-body">
                <div class="mb-4 form-group">
                    <label for="messagesInput" class="mb-3 form-label fw-semibold">
                        <i class="fas fa-pencil-alt me-2"></i>Your Messages:
                    </label>
                    <textarea class="shadow-sm form-control form-control-lg border-1" id="messagesInput" rows="4"
                        placeholder="Type your messages here..." x-model="messages" style="resize: none;"></textarea>
                    <small class="mt-2 text-muted d-block">
                        <i class="fas fa-info-circle me-1"></i>
                        Be clear and respectful in your messages
                    </small>
                </div>
                <div x-show="successMessage" class="mt-3 alert alert-success">
                    Messages sent successfully!
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </button>
                <button type="button" class="px-4 btn btn-primary" @click="sendMessages">
                    <i class="fas fa-paper-plane me-2"></i>Send Messages
                </button>
            </div>
        </div>
    </div>
</div>
