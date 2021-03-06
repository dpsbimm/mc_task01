<?php

namespace App\Providers;

use App\Api\DataTransformer\VehicleVariantsDataTransformer;
use App\Api\DataTransformer\VehicleVariantsDataTransformerInterface;
use App\Api\DataTransformer\VehicleVariantsDataWithRatingTransformer;
use App\Api\DataTransformer\VehicleVariantsDataWithRatingTransformerInterface;
use App\Api\Formatter\ResponseDatasetsFormatter;
use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\Api\VehicleApiService;
use App\Api\VehicleApiServiceInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverter;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverter;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterFacade;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterFacadeInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverter;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterFacade;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterFacadeInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleFetcher;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleFetcherInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcher;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcherInterface;
use App\Vehicle\VehicleService;
use App\Vehicle\VehicleServiceInterface;
use App\Vehicle\VehicleVariantsService;
use App\Vehicle\VehicleVariantsServiceInterface;
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
        $this->app->bind(ResponseDatasetsFormatterInterface::class, ResponseDatasetsFormatter::class);
        $this->app->bind(VehicleApiServiceInterface::class, VehicleApiService::class);
        $this->app->bind(VehicleDataConverterInterface::class, VehicleDataConverter::class);
        $this->app->bind(VehicleDataConverterFacadeInterface::class, VehicleDataConverterFacade::class);
        $this->app->bind(VehicleFetcherInterface::class, VehicleFetcher::class);
        $this->app->bind(VehicleServiceInterface::class, VehicleService::class);
        $this->app->bind(VehicleVariantsDataConverterInterface::class, VehicleVariantsDataConverter::class);
        $this->app->bind(VehicleVariantsDataConverterFacadeInterface::class, VehicleVariantsDataConverterFacade::class);
        $this->app->bind(VehicleVariantsDataTransformerInterface::class, VehicleVariantsDataTransformer::class);
        $this->app->bind(
            VehicleVariantsDataWithRatingTransformerInterface::class,
            VehicleVariantsDataWithRatingTransformer::class
        );
        $this->app->bind(VehicleVariantsFetcherInterface::class, VehicleVariantsFetcher::class);
        $this->app->bind(VehicleVariantsServiceInterface::class, VehicleVariantsService::class);
    }
}
