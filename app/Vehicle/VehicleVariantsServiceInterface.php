<?php

namespace App\Vehicle;

interface VehicleVariantsServiceInterface
{
    /**
     * Get vehicle variants data.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     *
     * @return array
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName);
}
