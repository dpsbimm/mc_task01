<?php

namespace Tests\Unit\App\Vehicle;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcherInterface;
use App\Vehicle\VehicleVariantsService;

class VehicleVariantsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleVariantsService
     */
    private $service;

    /**
     * @var VehicleVariantsFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $variantsFetcher;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->variantsFetcher = $this->createVehicleVariantsFetcherInterfaceMock();

        $this->service = new VehicleVariantsService($this->variantsFetcher);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->service = null;
        $this->variantsFetcher = null;
    }

    public function testGetVehicleVariantsDataSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepVariantsData = ['some vehicle variants data'];

        $this->variantsFetcher->expects($this->once())
            ->method('getVehicleVariantsData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($prepVariantsData));

        $variantsData = $this->service->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepVariantsData, $variantsData);
    }

    /**
     * Create mock for VehicleVariantsFetcherInterface.
     *
     * @return VehicleVariantsFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsFetcherInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsFetcherInterface::class)->getMock();
    }
}
