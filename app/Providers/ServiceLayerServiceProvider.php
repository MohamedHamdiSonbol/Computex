<?php

namespace App\Providers;

use App\Repositories\Front\AttributeRepository;
use App\Repositories\Front\BrandRepository;
use App\Repositories\Front\CartItemRepository;
use App\Repositories\Front\CategoryRepository;
use App\Repositories\Front\CityRepository;
use App\Repositories\Front\CouponRepository;
use App\Repositories\Front\CustomerRepository;
use App\Repositories\Front\DiscountRepository;
use App\Repositories\Front\GovernorateRepository;
use App\Repositories\Front\OrderRepository;
use App\Repositories\Front\ProductRepository;
use App\Services\Front\AttributeService;
use App\Services\Front\BrandService;
use App\Services\Front\CartItemService;
use App\Services\Front\CategoryService;
use App\Services\Front\CityService;
use App\Services\Front\CouponService;
use App\Services\Front\CustomerService;
use App\Services\Front\GovernorateService;
use App\Services\Front\OrderService;
use App\Services\Front\PriceCalculationService;
use App\Services\Front\SearchService;
use Illuminate\Support\ServiceProvider;
use App\Services\Front\ProductService;  //  <===

class ServiceLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AttributeService::class, function ($app) {
            return new AttributeService(
                $app->make(AttributeRepository::class),
            );
        });

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService(
                $app->make(ProductRepository::class),
                $app->make(DiscountRepository::class),
                $app->make(PriceCalculationService::class),
                $app->make(AttributeRepository::class),
            );
        });

        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepository::class),
                                       $app->make(ProductRepository::class),
                                       $app->make(AttributeRepository::class),
                                       $app->make(PriceCalculationService::class),

            );
        });

        $this->app->singleton(BrandService::class, function ($app) {
            return new BrandService(
                $app->make(BrandRepository::class),
                $app->make(ProductRepository::class),
                $app->make(AttributeRepository::class),
                $app->make(PriceCalculationService::class),


            );
        });

        $this->app->singleton(CartItemService::class, function ($app) {
            return new CartItemService(
                                       $app->make(CartItemRepository::class),
                                       $app->make(ProductRepository::class),
                                       $app->make(PriceCalculationService::class),
                                       $app->make(CouponService::class),
            );
        });

        $this->app->singleton(PriceCalculationService::class, function ($app) {
            return new PriceCalculationService($app->make(DiscountRepository::class));
        });

        $this->app->singleton(CouponService::class, function ($app) {
            return new CouponService(
                $app->make(CouponRepository::class),
//                $app->make(CartItemService::class),
                $app->make(PriceCalculationService::class)
            );
        });

        $this->app->singleton(CustomerService::class, function ($app) {
            return new CustomerService(
                $app->make(CustomerRepository::class),
//                $app->make(CartItemService::class),
            );
        });

        $this->app->singleton(OrderService::class, function ($app) {
            return new OrderService(
                $app->make(OrderRepository::class),
                $app->make(CustomerService::class),
                $app->make(CartItemService::class),
                $app->make(CouponRepository::class),

            );
        });

        $this->app->singleton(GovernorateService::class, function ($app) {
            return new GovernorateService(
                $app->make(GovernorateRepository::class),
            );
        });

        $this->app->singleton(CityService::class, function ($app) {
            return new CityService(
                $app->make(CityRepository::class),
            );
        });


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
