<?php

namespace App\Http\Middleware;

use App\Services\Front\CartItemService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCartNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//    public function handle(Request $request, Closure $next): Response
//    {
//        // Check if the authenticated customer has any items in their cart
//        // Replace 'cartItems' with the actual relationship name in your User/Customer model
//        if ($request->user()->cartItem()->count() === 0) {
//            return redirect()->route('front.cart')
//                ->with('error', 'سلة التسوق فارغة، يرجى إضافة منتجات أولاً');
//        }
//
//        return $next($request);
//    }
    protected $cartItemServ;

    public function __construct(CartItemService $cartItemServ)
    {
        $this->cartItemServ = $cartItemServ;
    }

    public function handle(Request $request, Closure $next)
    {
        $customer = Auth::guard('customers')->user();
        $customerId = $customer ? $customer->id : null;

        // Get the total items in the cart
        $cartCount = $this->cartItemServ->getCartCount($customerId);

        if (!$cartCount || $cartCount === 0) {
            // If it's a standard web page request, redirect them back to the cart page with a warning
            if (!$request->expectsJson()) {
                return redirect()->route('front.cart')->with('error', 'Your cart is empty.');
            }

            // If they tried to post via AJAX to a checkout endpoint, return an absolute error
            return response()->json(['error' => 'Cannot proceed with an empty cart.'], 400);
        }

        return $next($request);
    }
}
