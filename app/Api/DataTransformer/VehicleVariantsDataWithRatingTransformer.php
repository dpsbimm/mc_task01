<?php

namespace App\Api\DataTransformer;

class VehicleVariantsDataWithRatingTransformer implements VehicleVariantsDataWithRatingTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transformVehicleVariantsDataWithRating(array $variantsData)
    {
        $transformedData = [];

        foreach ($variantsData as $variantData) {
            if (is_array($variantData)
                && array_key_exists('OverallRating', $variantData)
                && array_key_exists('VehicleDescription', $variantData)
                && array_key_exists('VehicleId', $variantData)
            ) {
                $transformedData[] = [
                    'CrashRating' => $variantData['OverallRating'],
                    'Description' => $variantData['VehicleDescription'],
                    'VehicleId'   => $variantData['VehicleId'],
                ];
            }
        }

        return $transformedData;
    }
}
