<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class VehicleDataConverter implements VehicleDataConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convertApiDataToVehicleData(array $apiData)
    {
        $vehicleData = [];

        if ((1 === count($apiData))
            && is_array($apiData[0])
            && array_key_exists('OverallRating', $apiData[0])
            && array_key_exists('VehicleId', $apiData[0])
            && array_key_exists('VehicleDescription', $apiData[0])
        ) {
            $vehicleData = $apiData[0];
        }

        return $vehicleData;
    }
}
