<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Product;


class OrderController extends Controller
{
    public function myOrders()
{
    $orders = Auth::user()->orders()->get();

    $orders->each(function ($order) {
        $orderProducts = json_decode($order->products, true);
        $order->products = collect($orderProducts)->map(function ($quantity, $productId) {
            $product = Product::find($productId);
            return [
                'name' => $product ? $product->name : 'Unknown Product',
                'price' => $product ? $product->price : 0,
                'quantity' => $quantity,
            ];
        });
    });

    return Inertia::render('MyOrders', ['orders' => $orders]);
}
}
