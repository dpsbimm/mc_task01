<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterFacade;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterInterface;

class VehicleModelDataConverterFacadeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiDataConverter;

    /**
     * @var VehicleModelDataConverterFacade
     */
    private $converter;

    /**
     * @var VehicleModelDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $vehicleModelDataConverter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->apiDataConverter = $this->createApiDataConverterInterfaceMock();
        $this->vehicleModelDataConverter = $this->createVehicleModelDataConverterInterfaceMock();

        $this->converter = new VehicleModelDataConverterFacade(
            $this->apiDataConverter,
            $this->vehicleModelDataConverter
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->converter = null;
        $this->vehicleModelDataConverter = null;
        $this->apiDataConverter = null;
    }

    public function testConvertApiResponseToVehicleModelDataSuccess()
    {
        $apiResponse = 'some API response';

        $prepApiData = ['some API data'];
        $prepModelData = ['some vehicle model data'];

        $this->apiDataConverter->expects($this->once())
            ->method('convertApiResponseToApiData')
            ->with($this->identicalTo($apiResponse))
            ->will($this->returnValue($prepApiData));

        $this->vehicleModelDataConverter->expects($this->once())
            ->method('convertApiDataToVehicleModelData')
            ->with($this->identicalTo($prepApiData))
            ->will($this->returnValue($prepModelData));

        $vehicleModelData = $this->converter->convertApiResponseToVehicleModelData($apiResponse);

        $this->assertSame($prepModelData, $vehicleModelData);
    }

    /**
     * Create mock for ApiDataConverterInterface.
     *
     * @return ApiDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createApiDataConverterInterfaceMock()
    {
        return $this->getMockBuilder(ApiDataConverterInterface::class)->getMock();
    }

    /**
     * Create mock for VehicleModelDataConverterInterface.
     *
     * @return VehicleModelDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleModelDataConverterInterfaceMock()
    {
        return $this->getMockBuilder(VehicleModelDataConverterInterface::class)->getMock();
    }
}
