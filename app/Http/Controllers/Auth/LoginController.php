<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ─── Afficher le formulaire de connexion
    public function showForm()
    {
        // Si déjà connecté → rediriger vers accueil
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    // ─── Traiter la connexion
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'L\'adresse email est obligatoire.',
            'email.email'       => 'L\'adresse email n\'est pas valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min'      => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        // Tentative de connexion
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirection selon le rôle
            if (Auth::user()->role === 'admin') {
                return redirect()->route('Admin.dashboard');
            }

            return redirect('/')->with('success', 'Bienvenue ' . Auth::user()->name . ' !');
        }

        // Échec → retour avec erreur
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ]);
    }

    // ─── Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté.');
    }
}