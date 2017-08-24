<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class VehicleModelDataConverterFacade implements VehicleModelDataConverterFacadeInterface
{
    /**
     * @var ApiDataConverterInterface
     */
    private $apiDataConverter;

    /**
     * @var VehicleModelDataConverterInterface
     */
    private $vehicleModelDataConverter;

    /**
     * Constructor.
     *
     * @param ApiDataConverterInterface          $apiDataConverter
     * @param VehicleModelDataConverterInterface $vehicleModelDataConverter
     */
    public function __construct(
        ApiDataConverterInterface $apiDataConverter,
        VehicleModelDataConverterInterface $vehicleModelDataConverter
    ) {
        $this->apiDataConverter = $apiDataConverter;
        $this->vehicleModelDataConverter = $vehicleModelDataConverter;
    }

    /**
     * @inheritDoc
     */
    public function convertApiResponseToVehicleModelData($apiResponse)
    {
        $apiData = $this->apiDataConverter->convertApiResponseToApiData($apiResponse);

        $vehicleModelData = $this->vehicleModelDataConverter->convertApiDataToVehicleModelData($apiData);

        return $vehicleModelData;
    }
}
