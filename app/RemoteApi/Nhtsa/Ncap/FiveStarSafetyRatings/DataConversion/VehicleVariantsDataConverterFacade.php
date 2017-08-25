<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class VehicleVariantsDataConverterFacade implements VehicleVariantsDataConverterFacadeInterface
{
    /**
     * @var ApiDataConverterInterface
     */
    private $apiDataConverter;

    /**
     * @var VehicleVariantsDataConverterInterface
     */
    private $vehicleVariantsDataConverter;

    /**
     * Constructor.
     *
     * @param ApiDataConverterInterface             $apiDataConverter
     * @param VehicleVariantsDataConverterInterface $vehicleVariantsDataConverter
     */
    public function __construct(
        ApiDataConverterInterface $apiDataConverter,
        VehicleVariantsDataConverterInterface $vehicleVariantsDataConverter
    ) {
        $this->apiDataConverter = $apiDataConverter;
        $this->vehicleVariantsDataConverter = $vehicleVariantsDataConverter;
    }

    /**
     * @inheritDoc
     */
    public function convertApiResponseToVehicleVariantsData($apiResponse)
    {
        $apiData = $this->apiDataConverter->convertApiResponseToApiData($apiResponse);

        $variantsData = $this->vehicleVariantsDataConverter->convertApiDataToVehicleVariantsData($apiData);

        return $variantsData;
    }
}
