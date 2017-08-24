<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Http\Controllers\VehicleController;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;

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

        $vehicleModelFetcher = $this->createVehicleModelFetcherInterfaceMock();

        $vehicleModelFetcher->expects($this->once())
            ->method('getVehicleModelData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($prepModelData));

        $result = $this->controller->showModels($vehicleModelFetcher, $modelYear, $manufacturer, $modelName);

        $this->assertSame(
            [
                'Count'   => count($prepModelData),
                'Results' => $prepModelData
            ],
            $result
        );
    }

    /**
     * Create mock for VehicleModelFetcherInterface.
     *
     * @return VehicleModelFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleModelFetcherInterfaceMock()
    {
        return $this->getMockBuilder(VehicleModelFetcherInterface::class)->getMock();
    }
}
