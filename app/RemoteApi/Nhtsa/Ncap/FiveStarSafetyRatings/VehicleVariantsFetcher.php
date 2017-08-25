<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterFacadeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class VehicleVariantsFetcher implements VehicleVariantsFetcherInterface
{
    const REQUEST_URL_TEMPLATE
        = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/%s/make/%s/model/%s?format=json';

    /**
     * @var ClientInterface
     */
    private $apiClient;

    /**
     * @var VehicleVariantsDataConverterFacadeInterface
     */
    private $dataConverterFacade;

    /**
     * Constructor.
     *
     * @param ClientInterface                             $apiClient
     * @param VehicleVariantsDataConverterFacadeInterface $dataConverterFacade
     */
    public function __construct(
        ClientInterface $apiClient,
        VehicleVariantsDataConverterFacadeInterface $dataConverterFacade
    ) {
        $this->apiClient = $apiClient;
        $this->dataConverterFacade = $dataConverterFacade;
    }

    /**
     * @inheritDoc
     */
    public function getVehicleVariantsData($modelYear, $manufacturer, $modelName)
    {
        $url = $this->getRequestUrl($modelYear, $manufacturer, $modelName);

        $variantsData = [];

        try {
            $response = $this->apiClient->request('GET', $url);

            if (200 === $response->getStatusCode()) {
                $variantsData = $this->dataConverterFacade
                    ->convertApiResponseToVehicleVariantsData((string) $response->getBody());
            }
        } catch (GuzzleException $e) {
            /*
             * ignore error
             * (no error handling, just an empty result)
             */
        }

        return $variantsData;
    }

    /**
     * Get request URL.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $model
     *
     * @return string
     */
    private function getRequestUrl($modelYear, $manufacturer, $model)
    {
        return sprintf(self::REQUEST_URL_TEMPLATE, $modelYear, $manufacturer, $model);
    }
}
