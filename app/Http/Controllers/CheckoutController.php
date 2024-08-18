<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $products = Product::find(array_keys($cart));

        $lineItems = [];
        
        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cart[$product->id],
            ];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            ]);

            return Jetstream::inertia()->render($request, 'Cart', [
                'sessionURL' => $session->url,
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
    
        if (!$sessionId) {
            return response()->json(['error' => 'Invalid session ID'], 400);
        }
    
        Stripe::setApiKey(config('services.stripe.secret'));
    
        try {
            $session = StripeSession::retrieve($sessionId);
    
            $cart = session()->get('cart', []);
            $products = Product::find(array_keys($cart));
    
            $totalAmount = array_reduce($products->toArray(), function ($carry, $product) use ($cart) {
                return $carry + ($product['price'] * $cart[$product['id']]);
            }, 0);
    
            $customerDetails = $session->customer_details;
            $customerEmail = $customerDetails->email;
            $customerName = $customerDetails->name;

            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $user = User::firstOrCreate(
                    ['email' => $customerEmail],
                    [
                        'name' => $customerName,
                        'password' => Hash::make(Str::random(16)), 
                    ]
                );
                Auth::login($user);
            }
    
            $order = Order::create([
                'user_id' => $user->id,
                'stripe_session_id' => $session->id,
                'total_amount' => $totalAmount,
                'products' => json_encode($cart),
            ]);
    
            session()->put('order', $order);
    
            session()->forget('cart');
    
            return Inertia::render('CheckoutSuccess', [
                'order' => $order,
            ]);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}

