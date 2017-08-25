<?php

namespace App\Api;

use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\Vehicle\VehicleVariantsServiceInterface;

class VehicleApiService implements VehicleApiServiceInterface
{
    /**
     * @var ResponseDatasetsFormatterInterface
     */
    private $responseFormatter;

    /**
     * @var VehicleVariantsServiceInterface
     */
    private $variantsService;

    /**
     * Constructor.
     *
     * @param ResponseDatasetsFormatterInterface $responseFormatter
     * @param VehicleVariantsServiceInterface    $variantsService
     */
    public function __construct(
        ResponseDatasetsFormatterInterface $responseFormatter,
        VehicleVariantsServiceInterface $variantsService
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->variantsService = $variantsService;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName)
    {
        $variantsData = $this->variantsService->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        return $this->responseFormatter->formatDatasets($variantsData);
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsDataByArray($variantsData)
    {
        if (is_array($variantsData)
            && array_key_exists('modelYear', $variantsData)
            && array_key_exists('manufacturer', $variantsData)
            && array_key_exists('model', $variantsData)
        ) {
            $result = $this->getVehicleVariantsData(
                $variantsData['modelYear'],
                $variantsData['manufacturer'],
                $variantsData['model']
            );
        } else {
            $result = $this->responseFormatter->formatDatasets([]);
        }

        return $result;
    }
}
