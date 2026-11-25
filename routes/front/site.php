<?php

use App\Http\Controllers\Front\BrandController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LanguageController;
use App\Http\Controllers\Front\LoginController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\RegisterController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register site routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('language/{lang}', LanguageController::class)->name('language.switch')
    ->whereAlpha('lang');
Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/search', [SearchController::class, 'fetchMatchedProducts'])->name('front.search');
//Route::get('/search', [SearchController::class, 'search'])->name('front.search');
//Route::get('/search/products', [SearchController::class, 'search'])->name('front.search');
Route::get('/new-products', [HomeController::class, 'fetchNewArrivalProducts'])->name('front.newArrivalProducts');
Route::get('/top-selling-products', [HomeController::class, 'fetchTopSellingProducts'])->name('front.topSellingProducts');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('front.category.show')
    ->where('category', '[\p{L}0-9\-_]+');

Route::get('/categories/filter/{category}', [CategoryController::class, 'filter'])->name('front.category.filter')
    ->whereNumber('category')
    ->missing(function (Request $request) {
    // If it's an AJAX/JSON request, return JSON
    if ($request->expectsJson()) {
        return response()->json([
            'status'  => 'error',
            'message' => 'عفواً، هذا القسم غير موجود',
        ], 404);
    }
});

Route::get('/brands/{brand:slug}', [BrandController::class, 'show'])->name('front.brand.show')
    ->where('brand', '[\p{L}0-9\-_]+');
Route::get('/brands/filter/{brand}', [BrandController::class, 'filter'])->name('front.brand.filter')
    ->whereNumber('category')->missing(function (Request $request) {
    // If it's an AJAX/JSON request, return JSON
    if ($request->expectsJson()) {
        return response()->json([
            'status'  => 'error',
            'message' => 'عفواً، هذا البراند غير موجود',
        ], 404);
    }
});

Route::get('/products/search', [ProductController::class, 'search'])->name('front.products.search');
Route::get('/products/search/filter', [ProductController::class, 'filter'])->name('front.products.search.filter');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('front.product.show')->where('product', '[[\p{L}0-9\-_]+');
Route::get('/cart', [CartController::class, 'index'])->name('front.cart');
Route::get('/cart/refresh', [CartController::class, 'refresh'])->name('front.cart.refresh');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('front.cart.add')
    ->whereNumber('product')->missing(function (Request $request) {
    // If it's an AJAX/JSON request, return JSON
    if ($request->expectsJson()) {
        return response()->json([
            'status'  => 'error',
            'message' => 'عفواً، هذا المنتج غير موجود',
        ], 404);
    }
});
Route::post('/cart/add-coupon', [CartController::class, 'addCoupon'])->name('front.cart.addCoupon')->middleware('throttle:5,1');
Route::post('/cart/increase/{product}', [CartController::class, 'increase'])->name('front.cart.increase')
    ->whereNumber('product');
Route::post('/cart/decrease/{product}', [CartController::class, 'decrease'])->name('front.cart.decrease')
    ->whereNumber('product');
Route::delete('/cart/destroy/{product}', [CartController::class, 'destroy'])->name('front.cart.destroy')
    ->whereNumber('product');

Route::middleware('auth:customers')->group(function () {
    Route::get('/checkout', [checkoutController::class, 'index'])->name('front.checkout')->middleware('cart.not.empty');
    Route::post('/checkout/shipping', [checkoutController::class, 'shipping'])->name('front.checkout.shipping')->middleware('cart.not.empty');
    Route::post('/order', [OrderController::class, 'store'])->name('front.order.store');
    Route::get('/order-track/{order_number}', [OrderController::class, 'trackOrder'])->name('front.order.trackOrder');
    Route::delete('/logout', [LoginController::class, 'destroy'])->name('front.logout');
    Route::get('/customer/profile', [CustomerController::class, 'index'])->name('front.customers.index');
    Route::get('/customer/security', [CustomerController::class, 'security'])->name('front.customers.security');
    Route::patch('/customer/security/update-password', [CustomerController::class, 'updatePassword'])->name('front.customers.security.update')->middleware('throttle:5,1');
    Route::get('/customer/orders', [CustomerController::class, 'orders'])->name('front.customers.orders');

});

Route::middleware('guest:customers')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('front.login.create');
    Route::post('/login', [LoginController::class, 'store'])->name('front.login.store');

    Route::get('/register', [RegisterController::class, 'create'])->name('front.register.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('front.register.store');
    Route::get('/register/governorates/{governorate}', [RegisterController::class, 'fetchCities'])->name('front.register.fetchCities');
});


Route::fallback(fn() => to_route('front.404'));
Route::view('/404', 'front.not_found')->name('front.404');























//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
//
//require base_path('routes/auth.php');
