<?php

namespace App\Http\Controllers;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;

class VehicleController extends Controller
{
    /**
     * Show models.
     *
     * @param VehicleModelFetcherInterface $modelFetcher
     * @param string                       $modelYear
     * @param string                       $manufacturer
     * @param string                       $modelName
     *
     * @return array
     */
    public function showModels(VehicleModelFetcherInterface $modelFetcher, $modelYear, $manufacturer, $modelName)
    {
        $modelData = $modelFetcher->getVehicleModelData($modelYear, $manufacturer, $modelName);

        return [
            'Count'   => count($modelData),
            'Results' => $modelData,
        ];
    }
}
