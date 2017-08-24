<?php

namespace App\Http\Controllers;

use App\Api\VehicleApiServiceInterface;

class VehicleController extends Controller
{
    /**
     * Show models.
     *
     * @param VehicleApiServiceInterface $apiService
     * @param string                     $modelYear
     * @param string                     $manufacturer
     * @param string                     $modelName
     *
     * @return array
     */
    public function showModels(VehicleApiServiceInterface $apiService, $modelYear, $manufacturer, $modelName)
    {
        return $apiService->getVehicleModelData($modelYear, $manufacturer, $modelName);
    }
}
