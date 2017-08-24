<?php

namespace App\Http\Controllers;

use App\Api\VehicleApiServiceInterface;
use Illuminate\Http\Request;

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

    /**
     * Show models (data input via POST).
     *
     * @param VehicleApiServiceInterface $apiService
     * @param Request                    $request
     *
     * @return array
     */
    public function showModelsPost(VehicleApiServiceInterface $apiService, Request $request)
    {
        $jsonData = $request->json()->all();

        return $apiService->getVehicleModelDataByArray($jsonData);
    }
}
