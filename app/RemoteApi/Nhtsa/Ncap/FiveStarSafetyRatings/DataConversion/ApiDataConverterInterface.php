<?php

namespace App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

interface ApiDataConverterInterface
{
    /**
     * Convert API response to API data.
     *
     * @param string $apiResponse
     *
     * @return array
     */
    public function convertApiResponseToApiData($apiResponse);
}
