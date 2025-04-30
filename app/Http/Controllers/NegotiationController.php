<?php
namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NegotiationController extends Controller
{
    public function startConversation(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);
        
        $conversation = Conversation::firstOrCreate([
            'service_id' => $serviceId,
            'customer_id' => Auth::id(),
            'provider_id' => $service->user_id
        ]);
        
        return redirect()->route('negotiation.chat', $conversation->id);
    }

    public function showChat($conversationId)
    {
        $conversation = Conversation::with(['messages.user', 'service'])
            ->where('id', $conversationId)
            ->where(function($query) {
                $query->where('customer_id', Auth::id())
                      ->orWhere('provider_id', Auth::id());
            })
            ->firstOrFail();
            
        return view('negotiation.chat', compact('conversation'));
    }

    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string',
            'is_price_proposal' => 'sometimes|boolean'
        ]);
        
        $conversation = Conversation::findOrFail($conversationId);
        
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_price_proposal' => $request->is_price_proposal ?? false
        ]);
        
        if ($request->is_price_proposal) {
            $conversation->update([
                'is_negotiated' => true,
                'proposed_price' => $request->message,
                'status' => 'pending'
            ]);
        }
        
        // Broadcast event untuk real-time chat
        event(new NewMessage($message));
        
        return response()->json($message);
    }

    public function respondToProposal(Request $request, $conversationId)
    {
        $request->validate([
            'response' => 'required|in:accept,reject'
        ]);
        
        $conversation = Conversation::where('id', $conversationId)
            ->where('provider_id', Auth::id())
            ->firstOrFail();
            
        $conversation->update([
            'status' => $request->response
        ]);
        
        return redirect()->back()->with('success', 'Response sent successfully');
    }
}