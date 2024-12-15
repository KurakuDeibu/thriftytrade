<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{

    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function message($userId)
    {

    //    $createdConversation =   Conversation::updateOrCreate(['sender_id' => auth()->id(), 'receiver_id' => $userId]);

      $authenticatedUserId = auth()->id();

      # Check if conversation already exists
      $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $authenticatedUserId)
                    ->where('receiver_id', $userId);
                })
            ->orWhere(function ($query) use ($authenticatedUserId, $userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', $authenticatedUserId);
            })->first();

      if ($existingConversation) {
          # Conversation already exists, redirect to existing conversation
          return redirect()->route('chat', ['query' => $existingConversation->id]);
      }

      # Create new conversation
      $createdConversation = Conversation::create([
          'sender_id' => $authenticatedUserId,
          'receiver_id' => $userId,
      ]);

        return redirect()->route('chat', ['query' => $createdConversation->id])->with('info', 'Created a conversation');

    }

    public function render()
    {
        $finders = User::where('isFinder', true)
        ->when($this->search, function ($query) {
            return $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->paginate(8);


        return view('livewire.users', [
            'users' => User::where('id', '!=', auth()->id())
            ->where('isFinder', true)->get(),
            'finders' => $finders,
        ]);
    }
}