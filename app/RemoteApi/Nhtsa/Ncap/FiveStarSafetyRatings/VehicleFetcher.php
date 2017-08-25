<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterFacadeInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class VehicleFetcher implements VehicleFetcherInterface
{
    const REQUEST_URL_TEMPLATE = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/%s?format=json';

    /**
     * @var ClientInterface
     */
    private $apiClient;

    /**
     * @var VehicleDataConverterFacadeInterface
     */
    private $dataConverterFacade;

    /**
     * Constructor.
     *
     * @param ClientInterface                     $apiClient
     * @param VehicleDataConverterFacadeInterface $dataConverterFacade
     */
    public function __construct(
        ClientInterface $apiClient,
        VehicleDataConverterFacadeInterface $dataConverterFacade
    ) {
        $this->apiClient = $apiClient;
        $this->dataConverterFacade = $dataConverterFacade;
    }

    /**
     * Get request URL.
     *
     * @param string $vehicleId
     *
     * @return string
     */
    private function getRequestUrl($vehicleId)
    {
        return sprintf(self::REQUEST_URL_TEMPLATE, $vehicleId);
    }

    /**
     * @inheritDoc
     */
    public function getVehicleData($vehicleId)
    {
        $url = $this->getRequestUrl($vehicleId);

        $modelData = [];

        try {
            $response = $this->apiClient->request('GET', $url);

            if (200 === $response->getStatusCode()) {
                $modelData = $this->dataConverterFacade
                    ->convertApiResponseToVehicleData((string) $response->getBody());
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
