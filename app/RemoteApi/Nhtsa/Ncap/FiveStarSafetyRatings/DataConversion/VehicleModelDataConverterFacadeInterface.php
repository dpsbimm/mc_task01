<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface VehicleModelDataConverterFacadeInterface
{
    /**
     * Convert API response to vehicle model data.
     *
     * @param string $apiResponse
     *
     * @return array
     */
    public function convertApiResponseToVehicleModelData($apiResponse);
}
