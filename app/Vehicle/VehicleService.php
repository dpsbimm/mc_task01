<?php

namespace App\Vehicle;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleFetcherInterface;

class VehicleService implements VehicleServiceInterface
{
    /**
     * @var VehicleFetcherInterface
     */
    private $vehicleFetcher;

    /**
     * Constructor.
     *
     * @param VehicleFetcherInterface $vehicleFetcher
     */
    public function __construct(VehicleFetcherInterface $vehicleFetcher)
    {
        $this->vehicleFetcher = $vehicleFetcher;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleData($vehicleId)
    {
        return $this->vehicleFetcher->getVehicleData($vehicleId);
    }
}
