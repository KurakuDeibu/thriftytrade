<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SendMessageController extends Controller
{

    public function index()
    {
        return view('chat.chat-message');
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'userId' => 'required|integer',
                'receiverId' => 'required|integer',
                'productId' => 'required|integer',
                'messages' => 'required|string|min:1',
            ]);

            // Create a new chat message
            ChatMessage::create([
                'user_id' => $request->userId,
                'receiver_id' => $request->receiverId,
                'products_id' => $request->productId,
                'messages' => $request->messages,
            ]);

            return response()->json(['success' => true, 'message' => 'Messages sent successfully.']);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error in SendMessageController@store: ' . $e->getMessage());

            return response()->json(['success' => false, 'message' => 'Failed to send messages.'], 500);
        }
    }

    public function showUsers()
    {
        $conversations = ChatMessage::where('user_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();

        $users = $conversations->map(function($conversation){
            if($conversation->user_id === auth()->id()){
                return $conversation->receiver;
            }
            return $conversation->sender;
        })->unique();

        return response()->json($users);
    }

    public function showMessages(Request $request, $id)
    {
        $messages = ChatMessage::with(['user', 'products', 'offers'])
            ->where(function($query) use ($id) {
                $query->where('receiver_id', auth()->id())
                    ->where('user_id', $id);
            })
            ->orWhere(function($query) use ($id) {
                $query->where('user_id', auth()->id())
                    ->where('receiver_id', $id);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($message) {
                return [
                    'id' => $message->id,
                    'messages' => $message->messages,
                    'user_id' => $message->user_id,
                    'receiver_id' => $message->receiver_id,
                    'created_at' => $message->created_at,
                    'self_owned' => $message->user_id === auth()->id(),
                    'product' => $message->products,
                ];
            });

             // If no messages found
            if ($messages->isEmpty()) {
                return response()->json([
                    'message' => 'No messages found',
                    'product' => null
                ], 404);
            }

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        // Validate the request
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        // Ensure the user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $sender = Auth::user();

        $message = ChatMessage::create([
            'user_id' => $sender->id,
            'receiver_id' => $request->receiver_id,
            'messages' => $request->message,
        ]);

        // Can broadcast the message or trigger an event here
        // to have an real-time communication (WIP)

        return response()->json([
            'message' => $message,
        ], 201);
    }


}