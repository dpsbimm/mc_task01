<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Api\VehicleApiServiceInterface;
use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;

class VehicleControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleController
     */
    private $controller;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->controller = new VehicleController();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->controller = null;
    }

    public function testShowVariantsSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepVariantsData = ['some valid variants data'];

        $apiService = $this->createVehicleApiServiceInterfaceMock();

        $apiService->expects($this->once())
            ->method('getVehicleVariantsData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($prepVariantsData));

        $result = $this->controller->showVariants($apiService, $modelYear, $manufacturer, $modelName);

        $this->assertSame($prepVariantsData, $result);
    }

    public function testShowVariantsPostSuccess()
    {
        $jsonData = [
            'valid'   => 'model',
            'request' => 'data',
        ];

        $request = new Request([], [], [], [], [], [], json_encode($jsonData));

        $prepVariantsData = ['some valid variants data'];

        $apiService = $this->createVehicleApiServiceInterfaceMock();

        $apiService->expects($this->once())
            ->method('getVehicleVariantsDataByArray')
            ->with($this->identicalTo($jsonData))
            ->will($this->returnValue($prepVariantsData));

        $result = $this->controller->showVariantsPost($apiService, $request);

        $this->assertSame($prepVariantsData, $result);
    }

    /**
     * Create mock for VehicleApiServiceInterface.
     *
     * @return VehicleApiServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleApiServiceInterfaceMock()
    {
        return $this->getMockBuilder(VehicleApiServiceInterface::class)->getMock();
    }
}
