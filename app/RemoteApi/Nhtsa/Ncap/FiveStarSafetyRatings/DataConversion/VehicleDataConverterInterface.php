<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface VehicleDataConverterInterface
{
    /**
     * Convert API data to vehicle data.
     *
     * @param array $apiData
     *
     * @return array
     */
    public function convertApiDataToVehicleData(array $apiData);
}
