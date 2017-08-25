<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface VehicleVariantsDataConverterInterface
{
    /**
     * Convert API data to vehicle variants data.
     *
     * @param array $apiData
     *
     * @return array
     */
    public function convertApiDataToVehicleVariantsData(array $apiData);
}
