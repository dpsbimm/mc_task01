<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

interface VehicleFetcherInterface
{
    /**
     * Get vehicle data from API.
     *
     * @param string $vehicleId
     *
     * @return array
     */
    public function getVehicleData($vehicleId);
}
