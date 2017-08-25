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

    /**
     * @param array       $queryStringValues
     * @param string|null $expWithRating
     *
     * @dataProvider provideShowVariantsData
     */
    public function testShowVariantsSuccess(array $queryStringValues, $expWithRating)
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $request = new Request($queryStringValues);

        $prepVariantsData = ['some valid variants data'];

        $apiService = $this->createVehicleApiServiceInterfaceMock();

        $apiService->expects($this->once())
            ->method('getVehicleVariantsData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName),
                $this->identicalTo($expWithRating)
            )
            ->will($this->returnValue($prepVariantsData));

        $result = $this->controller->showVariants($apiService, $request, $modelYear, $manufacturer, $modelName);

        $this->assertSame($prepVariantsData, $result);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideShowVariantsData()
    {
        return [
            'no query string values' => [
                [],
                null,
            ],
            'query string value withRating = "true"' => [
                [
                    'withRating' => 'true',
                ],
                'true',
            ],
            'query string value withRating = "bananas"' => [
                [
                    'withRating' => 'bananas',
                ],
                'bananas',
            ],
        ];
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
