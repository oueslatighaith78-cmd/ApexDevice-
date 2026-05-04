<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ── Liste des utilisateurs
    public function index()
    {
        $users = User::withCount(['orders', 'products'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('Admin.users', compact('users'));
    }

    // ── Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer un administrateur.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "L'utilisateur '{$user->name}' a été supprimé.");
    }

    // ── Changer le rôle d'un utilisateur
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier votre propre rôle.');
        }

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', "Rôle de '{$user->name}' mis à jour.");
    }

    // ── Envoyer un message à un utilisateur
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        \App\Models\Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $id,
            'content'     => $request->content,
            'is_read'     => false,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Message envoyé avec succès.');
    }
}