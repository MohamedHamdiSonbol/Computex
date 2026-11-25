<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::domain('admin.computex.test')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'create'])->name('admin.login.create');
        Route::post('/login', [LoginController::class, 'store'])->name('admin.login.store');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::delete('/logout', [LoginController::class, 'destroy'])->name('admin.logout');


        #################################### Start Languages Route ####################################
        Route::get('language/{lang}', [LanguageController::class, 'switch'])->name('language.switch')
            ->whereAlpha('lang');

        Route::resource('/languages', LanguageController::class)->except('show')->names('admin.languages')->missing(fn() => to_route('admin.languages.index')->with('error', 'عفواً،  هذه اللغة غير موجودة'));
        #################################### end Languages Route ######################################


        ##################################### Start Categories Route ####################################
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('admin.categories.toggleStatus');

        Route::delete('categories/{category}/truncate', [CategoryController::class, 'truncate'])
            ->name('admin.categories.truncate');

        Route::resource('/categories', CategoryController::class)->names('admin.categories')->missing(fn() => to_route('admin.categories.index')->with('error', 'عفواً، هذا القسم غير موجود'));
        #################################### end Categories Route ######################################


        ##################################### Start Brands Route ####################################
        Route::patch('brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])
            ->name('admin.brands.toggleStatus');

        Route::delete('brands/{brand}/truncate', [BrandController::class, 'truncate'])
            ->name('admin.brands.truncate');

        Route::resource('/brands', BrandController::class)->except('show')->names('admin.brands')->missing(fn() => to_route('admin.brands.index')->with('error', 'عفواً، هذه العلامة التجارية غير موجودة'));
        #################################### end Brands Route ######################################


        ##################################### Start Colors Route ####################################
        Route::patch('colors/{color}/toggle-status', [ColorController::class, 'toggleStatus'])
            ->name('admin.colors.toggleStatus');

//    Route::delete('colors/{color}/truncate', [BrandController::class, 'truncate'])
//        ->name('admin.colors.truncate');

        Route::resource('/colors', ColorController::class)->except('show')->names('admin.colors')->missing(fn() => to_route('admin.colors.index')->with('error', 'عفواً، هذا اللون غير موجود'));
        #################################### end Colors Route ######################################


        ###################################### Start Products Route ####################################
        Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
            ->name('admin.products.toggleStatus');

        Route::resource('/products', ProductController::class)->except('show')->names('admin.products')->missing(fn() => to_route('admin.products.index')->with('error', 'عفواً، هذا المنتج غير موجود'));
        #################################### end Products Route ##############################################


        ###################################### Start Attributes Route ########################################
        Route::patch('attributes/{attribute}/toggle-status', [AttributeController::class, 'toggleStatus'])
            ->name('admin.attributes.toggleStatus');

        Route::resource('attributes', AttributeController::class)->except('show')->names('admin.attributes')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        ###################################### end Attributes Route ############################################


        ####################################### Start Attribute Values Route ####################################
        Route::resource('attributes.attribute_values', AttributeValueController::class)->names('admin.attribute_values');
        ####################################### end Attribute Values Route ######################################

        ####################################### start Ajax Route ######################################

        Route::get('fetch/colors', [ColorController::class, 'fetchColors'])->name('admin.colors.fetchColors');

        Route::get('fetch/attributes', [AttributeController::class, 'fetchAttributes'])->name('admin.attributes.fetchAttributes');

        Route::get('fetch/attributes/{attribute}/values', [AttributeValueController::class, 'fetchAttributeValues'])->name('admin.attributes.fetchValues');
        ####################################### end Ajax Route  ######################################

        ####################################### Start Campaigns Route ####################################
        Route::get('/campaigns/fetchCampaignableId/{type}', [CampaignController::class, 'fetchCampaignableId'])->name('admin.campaigns.fetchCampaignableId');
        Route::patch('campaigns/{campaign}/toggle-status', [CampaignController::class, 'toggleStatus'])
            ->name('admin.campaigns.toggleStatus');
        Route::resource('/campaigns', CampaignController::class)->names('admin.campaigns')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        ####################################### end Campaigns Route ######################################

        ####################################### Start Coupons Route ####################################
//    Route::get('/coupons/fetchCampaignableId/{type}', [CouponController::class, 'fetchCampaignableId'])->name('admin.Coupons.fetchCampaignableId');
        Route::patch('coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])
            ->name('admin.coupons.toggleStatus');
        Route::resource('/coupons', CouponController::class)->names('admin.coupons')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        ####################################### end Coupons Route ######################################

        ####################################### Start Discounts Route ####################################
//    Route::get('/campaigns/fetchCampaignableId/{type}', [CampaignController::class, 'fetchCampaignableId'])->name('admin.campaigns.fetchCampaignableId');
        Route::patch('discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])
            ->name('admin.discounts.toggleStatus');
        Route::resource('/discounts', DiscountController::class)->names('admin.discounts')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        ####################################### end Discounts Route ######################################

        ######################################## Start Admin Management Route ####################################
//    Route::get('/campaigns/fetchCampaignableId/{type}', [CampaignController::class, 'fetchCampaignableId'])->name('admin.campaigns.fetchCampaignableId');
//    Route::patch('discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])
//        ->name('admin.discounts.toggleStatus');
        Route::resource('/admins', AdminController::class)->names('admin.admins')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        Route::resource('/roles', RoleController::class)->names('admin.roles')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        Route::resource('/permissions', PermissionController::class)->names('admin.permissions')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        ####################################### end Admin Management Route ######################################

        ####################################### Start Attribute Values Route ####################################
        Route::resource('/orders', OrderController::class)->names('admin.orders')->missing(fn() => to_route('admin.attributes.index')->with('error', 'عفواً، هذه الخاصية غير موجودة'));
        ####################################### end Attribute Values Route ######################################
    });


});

