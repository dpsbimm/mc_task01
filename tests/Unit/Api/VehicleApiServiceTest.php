<?php

namespace Tests\Unit\App\Api;

use App\Api\VehicleApiService;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;

class VehicleApiServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleModelFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $modelFetcher;

    /**
     * @var VehicleApiService
     */
    private $service;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->modelFetcher = $this->createVehicleModelFetcherInterfaceMock();

        $this->service = new VehicleApiService($this->modelFetcher);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->modelFetcher = null;
        $this->service = null;
    }

    public function testVehicleModelDataSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepModelData = ['some valid model data'];

        $this->modelFetcher->expects($this->once())
            ->method('getVehicleModelData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($prepModelData));

        $result = $this->service->getVehicleModelData($modelYear, $manufacturer, $modelName);

        $this->assertSame(
            [
                'Count'   => count($prepModelData),
                'Results' => $prepModelData,
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
