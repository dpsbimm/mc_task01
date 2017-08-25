<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class VehicleDataConverterFacade implements VehicleDataConverterFacadeInterface
{
    /**
     * @var ApiDataConverterInterface
     */
    private $apiDataConverter;

    /**
     * @var VehicleDataConverterInterface
     */
    private $vehicleDataConverter;

    /**
     * Constructor.
     *
     * @param ApiDataConverterInterface     $apiDataConverter
     * @param VehicleDataConverterInterface $vehicleDataConverter
     */
    public function __construct(
        ApiDataConverterInterface $apiDataConverter,
        VehicleDataConverterInterface $vehicleDataConverter
    ) {
        $this->apiDataConverter = $apiDataConverter;
        $this->vehicleDataConverter = $vehicleDataConverter;
    }

    /**
     * @inheritDoc
     */
    public function convertApiResponseToVehicleData($apiResponse)
    {
        $apiData = $this->apiDataConverter->convertApiResponseToApiData($apiResponse);

        $vehicleData = $this->vehicleDataConverter->convertApiDataToVehicleData($apiData);

        return $vehicleData;
    }
}
