<?php

namespace App\Api\DataTransformer;

interface VehicleVariantsDataWithRatingTransformerInterface
{
    /**
     * Transform vehicle variants data with rating.
     *
     * @param array $variantsData
     *
     * @return array
     */
    public function transformVehicleVariantsDataWithRating(array $variantsData);
}
