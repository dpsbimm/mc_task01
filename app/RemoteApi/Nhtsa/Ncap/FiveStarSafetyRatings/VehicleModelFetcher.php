<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterFacadeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class VehicleModelFetcher implements VehicleModelFetcherInterface
{
    const REQUEST_URL_TEMPLATE
        = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/%s/make/%s/model/%s?format=json';

    /**
     * @var ClientInterface
     */
    private $apiClient;

    /**
     * @var VehicleModelDataConverterFacadeInterface
     */
    private $dataConverterFacade;

    /**
     * Constructor.
     *
     * @param ClientInterface                          $apiClient
     * @param VehicleModelDataConverterFacadeInterface $dataConverterFacade
     */
    public function __construct(
        ClientInterface $apiClient,
        VehicleModelDataConverterFacadeInterface $dataConverterFacade
    ) {
        $this->apiClient = $apiClient;
        $this->dataConverterFacade = $dataConverterFacade;
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

    /**
     * @inheritDoc
     */
    public function getVehicleModelData($modelYear, $manufacturer, $modelName)
    {
        $url = $this->getRequestUrl($modelYear, $manufacturer, $modelName);

        $modelData = [];

        try {
            $response = $this->apiClient->request('GET', $url);

            if (200 === $response->getStatusCode()) {
                $modelData = $this->dataConverterFacade
                    ->convertApiResponseToVehicleModelData((string) $response->getBody());
            }
        } catch (GuzzleException $e) {
            /*
             * ignore error
             * (no error handling, just an empty result)
             */
        }

        return $modelData;
    }
}
