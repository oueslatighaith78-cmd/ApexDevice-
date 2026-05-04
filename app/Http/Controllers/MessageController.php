<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // ── Liste des conversations (inbox)
    public function inbox()
    {
        $userId   = Auth::id();
        $messages = Message::where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->with(['sender', 'receiver'])
                    ->get();

        return view('messages.inbox', compact('messages'));
    }

    // ── Conversation avec un utilisateur spécifique
    public function index($userId)
    {
        $messages = Message::where(function($q) use ($userId) {
                $q->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
            })
            ->orWhere(function($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $receiver = User::findOrFail($userId);
        $products = \App\Models\Product::all();

        return view('messages.show', compact('messages', 'receiver', 'products'));
    }

    // ── Envoyer un message depuis la conversation
    public function store(Request $request, $userId)
    {
        if (Auth::id() == $userId) {
            return back()->withErrors(['error' => 'Vous ne pouvez pas vous envoyer un message.']);
        }

        $request->validate([
            'content'    => 'required|string|max:1000',
            'product_id' => 'nullable|exists:products,id',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $userId,
            'product_id'  => $request->product_id,
            'content'     => $request->content,
            'is_read'     => false,
        ]);

        return redirect()->route('message.index', $userId);
    }

    // ── Envoyer un message depuis la page produit (Malak)
    public function storeFromProduct(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'product_id'  => 'nullable|exists:products,id',
            'content'     => 'required|string|max:2000',
        ]);

        if (Auth::id() == $request->receiver_id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous envoyer un message.');
        }

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'product_id'  => $request->product_id,
            'content'     => $request->content,
            'is_read'     => false,
        ]);

        return redirect()->back()->with('success', 'Message envoyé avec succès !');
    }

    // ── Marquer comme lu
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        if ($message->receiver_id == Auth::id()) {
            $message->update(['is_read' => true]);
        }
        return back();
    }
}
