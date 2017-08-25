<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface VehicleVariantsDataConverterFacadeInterface
{
    /**
     * Convert API response to vehicle variants data.
     *
     * @param string $apiResponse
     *
     * @return array
     */
    public function convertApiResponseToVehicleVariantsData($apiResponse);
}
