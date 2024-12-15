{{-- resources/views/livewire/message-modal.blade.php --}}
<div x-data="{ isOpen: @entangle('isOpen') }">
    @php
        $seller = \App\Models\User::find($userId);
    @endphp
    {{-- Message Button --}}
    @auth
        @if (auth()->id() !== $userId)
            @php
                $existingConversation = \App\Models\Conversation::where(function ($query) use ($userId) {
                    $query->where('sender_id', auth()->id())->where('receiver_id', $userId);
                })
                    ->orWhere(function ($query) use ($userId) {
                        $query->where('sender_id', $userId)->where('receiver_id', auth()->id());
                    })
                    ->first();
            @endphp

            @if ($existingConversation)
                <a href="{{ route('chat', $existingConversation->id) }}"
                    class="btn btn-primary flex items-center justify-center w-full text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    View Conversation
                </a>
            @else
                <button @click="isOpen = true"
                    class="btn btn-primary flex items-center justify-center w-full text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                    Message {{ $seller->name }}
                </button>
            @endif
        @endif
    @endauth


    {{-- Modal Overlay --}}
    <div x-show="isOpen" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
        {{-- Modal Container --}}
        <div x-show="isOpen" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative w-full max-w-md p-6 mx-auto bg-white rounded-lg shadow-xl">
            {{-- Close Button --}}
            <button @click="isOpen = false" wire:click="closeModal"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Modal Content --}}
            <div class="text-center">
                {{-- Seller Info --}}
                <div class="flex items-center justify-center mb-6">

                    <img src="{{ $seller->profile_photo_url ?? asset('default-avatar.png') }}" alt="{{ $seller->name }}"
                        class="w-16 h-16 rounded-full mr-4 object-cover">
                    <div class="text-left">
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ $seller->name }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            Seller
                        </p>
                    </div>
                </div>

                {{-- Message Form --}}
                <form wire:submit.prevent="sendMessage" class="space-y-4">
                    <div>
                        <label for="message" class="sr-only">Message</label>
                        <textarea wire:model.defer="body" id="message" rows="4"
                            class="block w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Type your message to the seller..."></textarea>
                    </div>

                    {{-- Validation Error --}}
                    @error('body')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Action Buttons --}}
                    <div class="flex space-x-4">
                        <button type="button" @click="isOpen = false" wire:click="closeModal"
                            class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-outline-primary w-full px-4 py-2 text-sm font-medium"
                            :disabled="$wire.body.trim()
                            === ''">
                            <i class="fas fa-paper-plane"></i>
                            <span wire:loading.remove>Send Message</span>
                            <span wire:loading>Sending...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush
