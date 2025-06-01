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
        
        // Get conversation between current user and service provider
        $messages = Message::with(['sender', 'receiver'])
            ->where('jasa_id', $jasa_id)
            ->where(function($query) use ($jasa) {
                $query->where(function($q) use ($jasa) {
                    $q->where('sender_id', Auth::id())
                      ->where('receiver_id', $jasa->user_id);
                })->orWhere(function($q) use ($jasa) {
                    $q->where('sender_id', $jasa->user_id)
                      ->where('receiver_id', Auth::id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('chat.show', compact('jasa', 'messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jasa_id' => 'required|exists:jasas,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'price_offer' => 'nullable|numeric|min:0'
        ]);

        $message = \App\Models\Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'jasa_id' => $validated['jasa_id'],
            'message' => $validated['message'],
            'price_offer' => $validated['price_offer']
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

        public function getMessages($jasaId)
    {
        $messages = Message::where('jasa_id', $jasaId)
            ->with('sender') // agar bisa akses nama pengirim
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}