<?php

namespace App\Api;

use App\Api\DataTransformer\VehicleVariantsDataTransformerInterface;
use App\Api\DataTransformer\VehicleVariantsDataWithRatingTransformerInterface;
use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\Vehicle\VehicleServiceInterface;
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
     * @var VehicleVariantsDataWithRatingTransformerInterface
     */
    private $variantsWithRatingTransformer;

    /**
     * @var VehicleServiceInterface
     */
    private $vehicleService;

    /**
     * Constructor.
     *
     * @param ResponseDatasetsFormatterInterface $responseFormatter
     * @param VehicleVariantsServiceInterface $variantsService
     * @param VehicleVariantsDataTransformerInterface $variantsTransformer
     * @param VehicleVariantsDataWithRatingTransformerInterface $variantsWithRatingTransformer
     * @param VehicleServiceInterface $vehicleService
     */
    public function __construct(
        ResponseDatasetsFormatterInterface $responseFormatter,
        VehicleVariantsServiceInterface $variantsService,
        VehicleVariantsDataTransformerInterface $variantsTransformer,
        VehicleVariantsDataWithRatingTransformerInterface $variantsWithRatingTransformer,
        VehicleServiceInterface $vehicleService
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->variantsService = $variantsService;
        $this->variantsTransformer = $variantsTransformer;
        $this->variantsWithRatingTransformer = $variantsWithRatingTransformer;
        $this->vehicleService = $vehicleService;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName, $withRating = null)
    {
        $variantsData = $this->variantsService->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $transformedData = $this->getTransformedDataForVehicleVariantsData(
            $variantsData,
            $this->checkWithRating($withRating)
        );

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

    /**
     * Check if withRating is set to a value that is equivalent to "true".
     *
     * @param string $withRating
     *
     * @return bool
     */
    private function checkWithRating($withRating)
    {
        return ('true' === $withRating);
    }

    /**
     * Get transformed data for vehicle variants data.
     *
     * @param array $variantsData
     * @param bool  $withRating
     *
     * @return array
     */
    private function getTransformedDataForVehicleVariantsData(array $variantsData, $withRating)
    {
        if ($withRating) {
            foreach ($variantsData as &$variantData) {
                $variantData = $this->vehicleService->getVehicleData($variantData['VehicleId']);
            }

            $transformedData = $this->variantsWithRatingTransformer
                ->transformVehicleVariantsDataWithRating($variantsData);
        } else {
            $transformedData = $this->variantsTransformer->transformVehicleVariantsData($variantsData);
        }

        return $transformedData;
    }
}
