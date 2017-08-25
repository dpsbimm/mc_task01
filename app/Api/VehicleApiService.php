<?php

namespace App\Api;

use App\Api\DataTransformer\VehicleVariantsDataTransformerInterface;
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
     * @var VehicleVariantsDataTransformerInterface
     */
    private $variantsTransformer;

    /**
     * Constructor.
     *
     * @param ResponseDatasetsFormatterInterface      $responseFormatter
     * @param VehicleVariantsServiceInterface         $variantsService
     * @param VehicleVariantsDataTransformerInterface $variantsTransformer
     */
    public function __construct(
        ResponseDatasetsFormatterInterface $responseFormatter,
        VehicleVariantsServiceInterface $variantsService,
        VehicleVariantsDataTransformerInterface $variantsTransformer
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->variantsService = $variantsService;
        $this->variantsTransformer = $variantsTransformer;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName)
    {
        $variantsData = $this->variantsService->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $transformedData = $this->variantsTransformer->transformVehicleVariantsData($variantsData);

        return $this->responseFormatter->formatDatasets($transformedData);
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
