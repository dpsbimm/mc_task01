<?php

namespace App\Api\DataTransformer;

class VehicleVariantsDataTransformer implements VehicleVariantsDataTransformerInterface
{
    /**
     * @inheritDoc
     */
    public function transformVehicleVariantsData(array $variantsData)
    {
        $transformedData = [];

        foreach ($variantsData as $variantData) {
            if (is_array($variantData)
                && array_key_exists('VehicleDescription', $variantData)
                && array_key_exists('VehicleId', $variantData)
            ) {
                $transformedData[] = [
                    'Description' => $variantData['VehicleDescription'],
                    'VehicleId'   => $variantData['VehicleId'],
                ];
            }
        }

        return $transformedData;
    }
}
