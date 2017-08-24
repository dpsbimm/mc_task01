<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class VehicleModelDataConverter implements VehicleModelDataConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convertApiDataToVehicleModelData(array $apiData)
    {
        $vehicleModelData = [];

        foreach ($apiData as $vehicleData) {
            if (is_array($vehicleData)
                && array_key_exists('VehicleDescription', $vehicleData)
                && array_key_exists('VehicleId', $vehicleData)
            ) {
                $vehicleModelData[] = [
                    'Description' => $vehicleData['VehicleDescription'],
                    'VehicleId'   => $vehicleData['VehicleId'],
                ];
            }
        }

        return $vehicleModelData;
    }
}
