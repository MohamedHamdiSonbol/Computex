<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Front\CustomerLoginRequest;
use App\Services\Front\CartItemService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('front.login');
    }

    public function store(CustomerLoginRequest $request, CartItemService $cartItemServ): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $cartItemServ->mergeGuestCartToDb(auth()->guard('customers')->user());
        return redirect()->intended(route('front.home'));
    }
//
    public function destroy(Request $request, CartItemService $cartItemServ): RedirectResponse
    {
        $customer = auth()->guard('customers')->user();
        $cartItemServ->removeAllCustomerProductsFromDBCart($customer?->id);

        Auth::guard('customers')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('front.home');
    }
}
