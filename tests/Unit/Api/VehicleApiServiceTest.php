<?php

namespace Tests\Unit\App\Api;

use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\Api\VehicleApiService;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcherInterface;

class VehicleApiServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleModelFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $modelFetcher;

    /**
     * @var ResponseDatasetsFormatterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $responseFormatter;

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
        $this->responseFormatter = $this->createResponseDatasetsFormatterInterfaceMock();

        $this->service = new VehicleApiService($this->modelFetcher, $this->responseFormatter);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->modelFetcher = null;
        $this->responseFormatter = null;
        $this->service = null;
    }

    public function testGetVehicleModelDataSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepModelData = ['some valid model data'];
        $prepFormattedData = ['some formatted valid model data'];

        $this->modelFetcher->expects($this->once())
            ->method('getVehicleModelData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($prepModelData));

        $this->responseFormatter->expects($this->once())
            ->method('formatDatasets')
            ->with($this->identicalTo($prepModelData))
            ->will($this->returnValue($prepFormattedData));

        $result = $this->service->getVehicleModelData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepFormattedData, $result);
    }

    /**
     * Create mock for ResponseDatasetsFormatterInterface.
     *
     * @return ResponseDatasetsFormatterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createResponseDatasetsFormatterInterfaceMock()
    {
        return $this->getMockBuilder(ResponseDatasetsFormatterInterface::class)->getMock();
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
