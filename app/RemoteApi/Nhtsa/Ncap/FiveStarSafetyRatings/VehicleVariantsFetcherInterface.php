<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

interface VehicleVariantsFetcherInterface
{
    /**
     * Get vehicle variants data from API.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     *
     * @return array
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName);
}
