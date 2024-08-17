<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $cart[$request->product_id] = $request->input('quantity', 1);
        session()->put('cart', $cart);
        return redirect()->route('cart.index');
    }
    
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = Product::find(array_keys($cart));
        return Inertia::render('Cart', ['products' => $products, 'cart' => $cart]);
    }

    public function productRemove(Request $request)
    {
        $cart = session()->get('cart', []);
    
        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }
    
        return redirect()->route('cart.index');
    }
}
