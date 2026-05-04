<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // ─── Afficher le formulaire d'inscription
    public function showForm()
    {
        // Si déjà connecté → rediriger vers accueil
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    // ─── Traiter l'inscription
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name'     => 'required|string|min:2|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            
        ], [
            'name.required'      => 'Le nom est obligatoire.',
            'name.min'           => 'Le nom doit contenir au moins 2 caractères.',
            'email.required'     => 'L\'adresse email est obligatoire.',
            'email.email'        => 'L\'adresse email n\'est pas valide.',
            'email.unique'       => 'Cette adresse email est déjà utilisée.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'terms.accepted'     => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        // Connecter automatiquement après inscription
        Auth::login($user);

        return redirect('/')->with('success', 'Bienvenue sur ApexDevice, ' . $user->name . ' !');
    }
}