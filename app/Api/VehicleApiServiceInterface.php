<?php

namespace App\Api;

interface VehicleApiServiceInterface
{
    /**
     * Get vehicle model data.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     *
     * @return array
     */
    public function getVehicleModelData($modelYear, $manufacturer, $modelName);
}
