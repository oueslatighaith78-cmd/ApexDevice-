<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load([
            'cart.items.product.category',
            'orders.orderItems.product.category',
            'notifications'
        ]);

        $cartItems = optional($user->cart)->items ?? collect();

        $cartTotal = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->product->price ?? 0);
        });

        $cartCount = $cartItems->sum('quantity');

        $orders = $user->orders
            ->sortByDesc('created_at')
            ->values();

        $recentOrders = $orders->take(4);

        $purchasedItems = $orders->flatMap(function ($order) {
            return $order->orderItems->map(function ($item) use ($order) {
                return [
                    'order_id' => $order->id,
                    'status'   => $order->status,
                    'date'     => $order->created_at,
                    'quantity' => $item->quantity,
                    'price'    => $item->price,
                    'product'  => $item->product,
                ];
            });
        })->sortByDesc('date')->values();

        $recentPurchases = $purchasedItems->take(6);

        $notifications = $user->notifications
            ->sortByDesc('created_at')
            ->take(6)
            ->values();

        $unreadNotifications = $user->notifications
            ->where('is_read', false)
            ->count();

        $validatedOrdersCount = $user->orders
            ->where('status', 'validee')
            ->count();

        $cancelledOrdersCount = $user->orders
            ->where('status', 'annulee')
            ->count();

        $totalSpent = $user->orders
            ->where('status', 'validee')
            ->sum('total');

        $ordersCount = $user->orders->count();

        return view('profile.index', compact(
            'user',
            'cartItems',
            'cartTotal',
            'cartCount',
            'orders',
            'ordersCount',
            'recentOrders',
            'purchasedItems',
            'recentPurchases',
            'notifications',
            'unreadNotifications',
            'validatedOrdersCount',
            'cancelledOrdersCount',
            'totalSpent'
        ));
    }
}
