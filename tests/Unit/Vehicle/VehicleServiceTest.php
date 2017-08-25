<?php

namespace Tests\Unit\App\Vehicle;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleFetcherInterface;
use App\Vehicle\VehicleService;

class VehicleServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleService
     */
    private $service;

    /**
     * @var VehicleFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $vehicleFetcher;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->vehicleFetcher = $this->createVehicleFetcherInterfaceMock();

        $this->service = new VehicleService($this->vehicleFetcher);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->service = null;
        $this->vehicleFetcher = null;
    }

    public function testGetVehicleDataSuccess()
    {
        $vehicleId = 9400;

        $prepVehicleData = ['some vehicle data'];

        $this->vehicleFetcher->expects($this->once())
            ->method('getVehicleData')
            ->with($this->identicalTo($vehicleId))
            ->will($this->returnValue($prepVehicleData));

        $vehicleData = $this->service->getVehicleData($vehicleId);

        $this->assertSame($prepVehicleData, $vehicleData);
    }

    /**
     * Create mock for VehicleFetcherInterface.
     *
     * @return VehicleFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleFetcherInterfaceMock()
    {
        return $this->getMockBuilder(VehicleFetcherInterface::class)->getMock();
    }
}
