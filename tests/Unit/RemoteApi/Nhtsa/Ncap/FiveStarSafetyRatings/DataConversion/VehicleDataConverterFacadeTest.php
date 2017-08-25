<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterFacade;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterInterface;

class VehicleDataConverterFacadeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiDataConverter;

    /**
     * @var VehicleDataConverterFacade
     */
    private $converter;

    /**
     * @var VehicleDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $vehicleDataConverter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->apiDataConverter = $this->createApiDataConverterInterfaceMock();
        $this->vehicleDataConverter = $this->createVehicleDataConverterInterfaceMock();

        $this->converter = new VehicleDataConverterFacade($this->apiDataConverter, $this->vehicleDataConverter);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->converter = null;
        $this->vehicleDataConverter = null;
        $this->apiDataConverter = null;
    }

    public function testConvertApiResponseToVehicleDataSuccess()
    {
        $apiResponse = 'some API response';

        $prepApiData = ['some API data'];
        $prepVehicleData = ['some vehicle data'];

        $this->apiDataConverter->expects($this->once())
            ->method('convertApiResponseToApiData')
            ->with($this->identicalTo($apiResponse))
            ->will($this->returnValue($prepApiData));

        $this->vehicleDataConverter->expects($this->once())
            ->method('convertApiDataToVehicleData')
            ->with($this->identicalTo($prepApiData))
            ->will($this->returnValue($prepVehicleData));

        $vehicleData = $this->converter->convertApiResponseToVehicleData($apiResponse);

        $this->assertSame($prepVehicleData, $vehicleData);
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
     * Create mock for VehicleDataConverterInterface.
     *
     * @return VehicleDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleDataConverterInterfaceMock()
    {
        return $this->getMockBuilder(VehicleDataConverterInterface::class)->getMock();
    }
}
