<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class VehicleVariantsDataConverter implements VehicleVariantsDataConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convertApiDataToVehicleVariantsData(array $apiData)
    {
        $variantsData = [];

        foreach ($apiData as $variantData) {
            if (is_array($variantData)
                && array_key_exists('VehicleDescription', $variantData)
                && array_key_exists('VehicleId', $variantData)
            ) {
                $variantsData[] = $variantData;
            }
        }

        return $variantsData;
    }
}
