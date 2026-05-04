<?php

use Illuminate\Support\Facades\Route;

// ── PAGE D'ACCUEIL ───────────────────────────────────────────
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ── AUTHENTIFICATION ─────────────────────────────────────────
Route::get('/login',    [App\Http\Controllers\Auth\LoginController::class, 'showForm'])->name('login');
Route::post('/login',   [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showForm'])->name('register');
Route::post('/register',[App\Http\Controllers\Auth\RegisterController::class, 'register']);
Route::post('/logout',  [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// ── PRODUITS (catalogue public) ──────────────────────────────
Route::get('/produits',           [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// ── BOUTIQUE + VENDEUR (Zina) ────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/boutique', [App\Http\Controllers\ProductController::class, 'boutique'])
         ->name('boutique.index');

    Route::get('/boutique/creer', [App\Http\Controllers\ProductController::class, 'create'])
         ->name('products.create');

    Route::post('/boutique', [App\Http\Controllers\ProductController::class, 'store'])
         ->name('products.store');

    Route::get('/boutique/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])
         ->name('products.edit');

    Route::put('/boutique/{product}', [App\Http\Controllers\ProductController::class, 'update'])
         ->name('products.update');

    Route::delete('/boutique/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])
         ->name('products.destroy');

    // ⚠️ /creer AVANT /{id} — sinon Laravel confond "creer" avec un ID
    Route::get('/vendeur/produits/creer', [App\Http\Controllers\ProductController::class, 'create'])
         ->name('vendeur.produits.create');

    Route::post('/vendeur/produits', [App\Http\Controllers\ProductController::class, 'store'])
         ->name('vendeur.produits.store');

});

// ── PANIER (Zina) ────────────────────────────────────────────
Route::prefix('panier')->middleware('auth')->name('panier.')->group(function () {
    Route::get('/',                     [App\Http\Controllers\PanierController::class, 'index'])->name('index');
    Route::post('/ajouter',             [App\Http\Controllers\PanierController::class, 'add'])->name('add');
    Route::post('/update',              [App\Http\Controllers\PanierController::class, 'update'])->name('update');
    Route::post('/supprimer',           [App\Http\Controllers\PanierController::class, 'remove'])->name('remove');
    Route::post('/vider',               [App\Http\Controllers\PanierController::class, 'clear'])->name('clear');
    Route::get('/paiement',             [App\Http\Controllers\PanierController::class, 'paiement'])->name('paiement');
    Route::post('/valider',             [App\Http\Controllers\PanierController::class, 'valider'])->name('valider');
    Route::get('/confirmation/{order}', [App\Http\Controllers\PanierController::class, 'confirmation'])->name('confirmation');
});

// ── PANIER ajout depuis page produit (Malak)
Route::post('/cart/add', [App\Http\Controllers\PanierController::class, 'add'])
     ->middleware('auth')->name('cart.add');

// ── PROFIL & COMMANDES (Abdo) ────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profil',        [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil',        [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/mes-commandes', [App\Http\Controllers\ProfileController::class, 'orders'])->name('orders.index');
});

// ── REVIEWS / AVIS (Malak) ───────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/reviews',        [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{id}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// ── MESSAGES (Rayen + Malak) ─────────────────────────────────
Route::middleware('auth')->group(function () {
    // inbox  — utilisé par messages/inbox.blade.php
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'inbox'])
         ->name('messages.index');

    // conversation — utilisé par inbox.blade.php → route('messages.show', $id)
    Route::get('/messages/{userId}',  [App\Http\Controllers\MessageController::class, 'index'])
         ->name('messages.show');

    // envoyer message — utilisé par show.blade.php → route('messages.store', $id)
    Route::post('/messages/{userId}', [App\Http\Controllers\MessageController::class, 'store'])
         ->name('messages.store');

    // envoyer depuis page produit (Malak)
    Route::post('/messages', [App\Http\Controllers\MessageController::class, 'storeFromProduct'])
         ->name('messages.storeFromProduct');
});

// ── ADMIN (Rayen) ─────────────────────────────────────────────
Route::prefix('Admin')->middleware(['auth'])->name('Admin.')->group(function () {
    Route::get('/',                        [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/utilisateurs',            [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('users.index');
    Route::delete('/utilisateurs/by-name', [App\Http\Controllers\Admin\DashboardController::class, 'destroyByName'])->name('users.destroyByName');
});