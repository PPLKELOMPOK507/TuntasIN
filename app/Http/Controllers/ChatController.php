<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show($jasa_id)
    {
        $jasa = Jasa::with('user')->findOrFail($jasa_id);
        $messages = Message::with('sender')
            ->where('jasa_id', $jasa_id)
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('jasa', 'messages'));
    }

    public function getMessages($jasa_id)
    {
        \Log::info('Fetching messages for jasa_id: ' . $jasa_id); // Debug log
        
        $messages = Message::with('sender')
            ->where('jasa_id', $jasa_id)
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
            
        \Log::info('Messages found: ' . $messages->count()); // Debug log
        
        return response()->json($messages);
    }

    public function store(Request $request)
    {
        \Log::info('Received message request', $request->all());

        $validated = $request->validate([
            'jasa_id' => 'required|exists:jasas,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'price_offer' => 'nullable|numeric|min:0'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
            'jasa_id' => $validated['jasa_id'],
            'message' => $validated['message'],
            'price_offer' => $validated['price_offer']
        ]);

        \Log::info('Message created', ['message' => $message]);

        return response()->json($message);
    }
}