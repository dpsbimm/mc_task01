<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

interface VehicleModelFetcherInterface
{
    /**
     * Get vehicle model data from API.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     *
     * @return array
     */
    public function getVehicleModelData($modelYear, $manufacturer, $modelName);
}
