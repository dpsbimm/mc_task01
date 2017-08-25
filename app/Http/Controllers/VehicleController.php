<?php

namespace App\Http\Controllers;

use App\Api\VehicleApiServiceInterface;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Show vehicle variants.
     *
     * @param VehicleApiServiceInterface $apiService
     * @param string                     $modelYear
     * @param string                     $manufacturer
     * @param string                     $modelName
     *
     * @return array
     */
    public function showVariants(VehicleApiServiceInterface $apiService, $modelYear, $manufacturer, $modelName)
    {
        return $apiService->getVehicleVariantsData($modelYear, $manufacturer, $modelName);
    }

    /**
     * Show vehicle variants (data input via POST).
     *
     * @param VehicleApiServiceInterface $apiService
     * @param Request                    $request
     *
     * @return array
     */
    public function showVariantsPost(VehicleApiServiceInterface $apiService, Request $request)
    {
        $jsonData = $request->json()->all();

        return $apiService->getVehicleVariantsDataByArray($jsonData);
    }
}
