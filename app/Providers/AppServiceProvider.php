<?php

namespace App\Providers;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverter;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverter;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterFacade;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterFacadeInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcher;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverterInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiDataConverterInterface::class, ApiDataConverter::class);
        $this->app->bind(ClientInterface::class, Client::class);
        $this->app->bind(VehicleModelDataConverterInterface::class, VehicleModelDataConverter::class);
        $this->app->bind(VehicleModelDataConverterFacadeInterface::class, VehicleModelDataConverterFacade::class);
        $this->app->bind(VehicleModelFetcherInterface::class, VehicleModelFetcher::class);
    }
}
