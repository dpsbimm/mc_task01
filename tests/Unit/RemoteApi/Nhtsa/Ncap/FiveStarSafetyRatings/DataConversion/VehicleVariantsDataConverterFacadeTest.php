<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverterInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterFacade;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterInterface;

class VehicleVariantsDataConverterFacadeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiDataConverter;

    /**
     * @var VehicleVariantsDataConverterFacade
     */
    private $converter;

    /**
     * @var VehicleVariantsDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $vehicleVariantsDataConverter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->apiDataConverter = $this->createApiDataConverterInterfaceMock();
        $this->vehicleVariantsDataConverter = $this->createVehicleVariantsDataConverterInterfaceMock();

        $this->converter = new VehicleVariantsDataConverterFacade(
            $this->apiDataConverter,
            $this->vehicleVariantsDataConverter
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->converter = null;
        $this->vehicleVariantsDataConverter = null;
        $this->apiDataConverter = null;
    }

    public function testConvertApiResponseToVehicleVariantsDataSuccess()
    {
        $apiResponse = 'some API response';

        $prepApiData = ['some API data'];
        $prepVariantsData = ['some vehicle variants data'];

        $this->apiDataConverter->expects($this->once())
            ->method('convertApiResponseToApiData')
            ->with($this->identicalTo($apiResponse))
            ->will($this->returnValue($prepApiData));

        $this->vehicleVariantsDataConverter->expects($this->once())
            ->method('convertApiDataToVehicleVariantsData')
            ->with($this->identicalTo($prepApiData))
            ->will($this->returnValue($prepVariantsData));

        $variantsData = $this->converter->convertApiResponseToVehicleVariantsData($apiResponse);

        $this->assertSame($prepVariantsData, $variantsData);
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
     * Create mock for VehicleVariantsDataConverterInterface.
     *
     * @return VehicleVariantsDataConverterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsDataConverterInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsDataConverterInterface::class)->getMock();
    }
}
