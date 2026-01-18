<?php
namespace App\Providers;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ShippingInterface;
use App\Repositories\Eloquent\ShippingRepository;
use App\Repositories\Contracts\Slider\SliderInterface;
use App\Repositories\Eloquent\Slider\SliderRepository;
use App\Repositories\Contracts\Dashboard\BrandInterface;
use App\Repositories\Eloquent\Dashboard\BrandRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
             $this->app->bind(ShippingInterface::class, ShippingRepository::class);
             $this->app->bind(SliderInterface::class,SliderRepository::class);
             $this->app->bind(BrandInterface::class, BrandRepository::class);
              $this->app->singleton('files', function () {
        return new Filesystem;
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
