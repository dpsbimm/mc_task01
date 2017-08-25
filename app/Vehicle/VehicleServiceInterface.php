<?php

namespace App\Vehicle;

interface VehicleServiceInterface
{
    /**
     * Get vehicle data.
     *
     * @param string $vehicleId
     *
     * @return array
     */
    public function getVehicleData($vehicleId);
}
