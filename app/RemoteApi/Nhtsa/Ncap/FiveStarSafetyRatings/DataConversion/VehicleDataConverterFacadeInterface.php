<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface VehicleDataConverterFacadeInterface
{
    /**
     * Convert API response to vehicle data.
     *
     * @param string $apiResponse
     *
     * @return array
     */
    public function convertApiResponseToVehicleData($apiResponse);
}
