<?php

namespace App\Api;

use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcherInterface;

class VehicleApiService implements VehicleApiServiceInterface
{
    /**
     * @var ResponseDatasetsFormatterInterface
     */
    private $responseFormatter;

    /**
     * @var VehicleVariantsFetcherInterface
     */
    private $variantsFetcher;

    /**
     * Constructor.
     *
     * @param ResponseDatasetsFormatterInterface $responseFormatter
     * @param VehicleVariantsFetcherInterface    $variantsFetcher
     */
    public function __construct(
        ResponseDatasetsFormatterInterface $responseFormatter,
        VehicleVariantsFetcherInterface $variantsFetcher
    ) {
        $this->responseFormatter = $responseFormatter;
        $this->variantsFetcher = $variantsFetcher;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName)
    {
        $variantsData = $this->variantsFetcher->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

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
