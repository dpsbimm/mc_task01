<?php

namespace App\Api;

use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;

class VehicleApiService implements VehicleApiServiceInterface
{
    /**
     * @var VehicleModelFetcherInterface
     */
    private $modelFetcher;

    /**
     * @var ResponseDatasetsFormatterInterface
     */
    private $responseFormatter;

    /**
     * Constructor.
     *
     * @param VehicleModelFetcherInterface       $modelFetcher
     * @param ResponseDatasetsFormatterInterface $responseFormatter
     */
    public function __construct(
        VehicleModelFetcherInterface $modelFetcher,
        ResponseDatasetsFormatterInterface $responseFormatter
    ) {
        $this->modelFetcher = $modelFetcher;
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleModelData($modelYear, $manufacturer, $modelName)
    {
        $modelData = $this->modelFetcher->getVehicleModelData($modelYear, $manufacturer, $modelName);

        return $this->responseFormatter->formatDatasets($modelData);
    }
}
