<?php

namespace App\Api;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;

class VehicleApiService implements VehicleApiServiceInterface
{
    /**
     * @var VehicleModelFetcherInterface
     */
    private $modelFetcher;

    /**
     * Constructor.
     *
     * @param VehicleModelFetcherInterface $modelFetcher
     */
    public function __construct(VehicleModelFetcherInterface $modelFetcher)
    {
        $this->modelFetcher = $modelFetcher;
    }

    /**
     * Format datasets for response.
     *
     * @param array $modelData
     *
     * @return array
     */
    private function formatDatasetsForResponse(array $modelData)
    {
        return [
            'Count'   => count($modelData),
            'Results' => $modelData,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getVehicleModelData($modelYear, $manufacturer, $modelName)
    {
        $modelData = $this->modelFetcher->getVehicleModelData($modelYear, $manufacturer, $modelName);

        return $this->formatDatasetsForResponse($modelData);
    }
}
