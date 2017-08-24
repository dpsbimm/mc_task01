<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

class ApiDataConverter implements ApiDataConverterInterface
{
    /**
     * @inheritDoc
     */
    public function convertApiResponseToApiData($apiResponse)
    {
        $jsonData = json_decode($apiResponse, true);

        if ((null === $jsonData)
            || !array_key_exists('Results', $jsonData)
            || !is_array($jsonData['Results'])
        ) {
            $apiData = [];
        } else {
            $apiData = $jsonData['Results'];
        }

        return $apiData;
    }
}
