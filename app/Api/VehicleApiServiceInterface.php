<?php

namespace App\Api;

interface VehicleApiServiceInterface
{
    /**
     * Get vehicle variants data.
     *
     * @param string      $modelYear
     * @param string      $manufacturer
     * @param string      $modelName
     * @param string|null $withRating
     *
     * @return array
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName, $withRating = null);

    /**
     * Get vehicle variants data by array.
     *
     * @param array|null $modelData
     *
     * @return array
     */
    public function getVehicleVariantsDataByArray($modelData);
}
