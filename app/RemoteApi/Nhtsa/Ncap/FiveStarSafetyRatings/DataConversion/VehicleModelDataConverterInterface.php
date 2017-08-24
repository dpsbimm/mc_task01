<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface VehicleModelDataConverterInterface
{
    /**
     * Convert API data to vehicle model data.
     *
     * @param array $apiData
     *
     * @return array
     */
    public function convertApiDataToVehicleModelData(array $apiData);
}
