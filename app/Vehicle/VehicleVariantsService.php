<?php

namespace App\Vehicle;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcherInterface;

class VehicleVariantsService implements VehicleVariantsServiceInterface
{
    /**
     * @var VehicleVariantsFetcherInterface
     */
    private $variantsFetcher;

    /**
     * Constructor.
     *
     * @param VehicleVariantsFetcherInterface $variantsFetcher
     */
    public function __construct(VehicleVariantsFetcherInterface $variantsFetcher)
    {
        $this->variantsFetcher = $variantsFetcher;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName)
    {
        return $this->variantsFetcher->getVehicleVariantsData($modelYear, $manufacturer, $modelName);
    }
}
