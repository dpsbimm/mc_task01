<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Api\VehicleApiServiceInterface;
use App\Http\Controllers\VehicleController;

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

    public function testShowModelsSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepModelData = ['some valid model data'];

        $apiService = $this->createVehicleApiServiceInterfaceMock();

        $apiService->expects($this->once())
            ->method('getVehicleModelData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($prepModelData));

        $result = $this->controller->showModels($apiService, $modelYear, $manufacturer, $modelName);

        $this->assertSame($prepModelData, $result);
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
