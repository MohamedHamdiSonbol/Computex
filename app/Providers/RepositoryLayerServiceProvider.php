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
use Illuminate\Support\ServiceProvider;
use App\Repositories\Front\ProductRepository;

class RepositoryLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AttributeRepository::class, fn() => new AttributeRepository());
        $this->app->singleton(ProductRepository::class, fn() => new ProductRepository());
        $this->app->singleton(CategoryRepository::class, fn() => new CategoryRepository());
        $this->app->singleton(BrandRepository::class, fn() => new BrandRepository());
        $this->app->singleton(CartItemRepository::class, fn() => new CartItemRepository());
        $this->app->singleton(CouponRepository::class, fn() => new CouponRepository());
        $this->app->singleton(DiscountRepository::class, fn() => new DiscountRepository());
        $this->app->singleton(CustomerRepository::class, fn() => new CustomerRepository());
        $this->app->singleton(OrderRepository::class, fn() => new OrderRepository());
        $this->app->singleton(GovernorateRepository::class, fn() => new GovernorateRepository());
        $this->app->singleton(CityRepository::class, fn() => new CityRepository());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
