<?php

namespace App\Api\DataTransformer;

interface VehicleVariantsDataTransformerInterface
{
    /**
     * Transform vehicle variants data.
     *
     * @param array $variantsData
     *
     * @return array
     */
    public function transformVehicleVariantsData(array $variantsData);
}
