<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Conversation;

class MessageModal extends Component
{
    public $userId;
    public $body = '';
    public $isOpen = false;

    // Validate input
    protected $rules = [
        'body' => 'required|min:1|max:1000'
    ];

    protected $messages = [
        'body.required' => 'Please enter a message.',
        'body.max' => 'Your message cannot exceed 1000 characters.'
    ];

    // Mount method to set the user ID
    public function mount($userId)
    {
        $this->userId = $userId;
    }

    // Open the message modal
    public function openModal()
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->isOpen = true;
    }

    // Close the message modal
    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset('body');
    }

    // Send message and redirect to chat
    public function sendMessage()
    {
        // Validate input
        $this->validate();

        // Ensure authenticated user
        $authenticatedUserId = auth()->id();
        if (!$authenticatedUserId) {
            return redirect()->route('login');
        }

        // Prevent messaging yourself
        if ($authenticatedUserId == $this->userId) {
            session()->flash('error', 'You cannot message yourself');
            return;
        }

        // Find or create conversation
        $conversation = Conversation::firstOrCreate(
            [
                'sender_id' => $authenticatedUserId,
                'receiver_id' => $this->userId
            ],
            [
                'sender_id' => $authenticatedUserId,
                'receiver_id' => $this->userId,
            ]
        );

        // Create first message if the conversation is new
        if ($conversation->wasRecentlyCreated) {
            $conversation->messages()->create([
                'body' => $this->body,
                'sender_id' => $authenticatedUserId,
                'receiver_id' => $this->userId,
            ]);
        }

        // Redirect to chat with the conversation query
        return redirect()->route('chat', ['query' => $conversation->id])
            ->with('success', 'Conversation started');
    }

    public function render()
    {
        return view('livewire.message-modal');
    }
}