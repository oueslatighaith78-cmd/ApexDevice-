<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();

        $loyalUsers = User::select('users.id', 'users.name', 'users.email',
                            DB::raw('SUM(orders.total) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 'validee')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();

        return view('Admin.dashboard', compact('productCount', 'loyalUsers'));
    }

    public function destroyByName(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,name',
        ]);

        $user = User::where('name', $request->username)->first();

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Vous ne pouvez pas supprimer un autre administrateur.');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', "L'utilisateur '{$request->username}' a été supprimé.");
    }
}