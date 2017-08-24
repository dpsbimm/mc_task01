<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverterFacadeInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleModelFetcher;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;

class VehicleModelFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiClient;

    /**
     * @var VehicleModelFetcher
     */
    private $fetcher;

    /**
     * @var VehicleModelDataConverterFacadeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dataConverterFacade;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->apiClient = $this->createClientInterfaceMock();
        $this->dataConverterFacade = $this->createVehicleModelDataConverterFacadeInterfaceMock();

        $this->fetcher = new VehicleModelFetcher($this->apiClient, $this->dataConverterFacade);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->fetcher = null;
        $this->dataConverterFacade = null;
        $this->apiClient = null;
    }

    public function testGetVehicleModelDataSuccessConnectionOrRemoteError()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $this->apiClient->expects($this->once())
            ->method('request')
            ->will($this->throwException(new TransferException()));

        $modelData = $this->fetcher->getVehicleModelData($modelYear, $manufacturer, $modelName);

        $this->assertSame([], $modelData);
    }

    public function testGetVehicleModelDataSuccessInvalidResponseCode()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepResponseCode = 500;
        $prepResponseBody = 'some response body';
        $prepResponse = new Response($prepResponseCode, [], $prepResponseBody);

        $this->apiClient->expects($this->once())
            ->method('request')
            ->with(
                $this->identicalTo('GET'),
                $this->isType('string')
            )
            ->will($this->returnValue($prepResponse));

        $modelData = $this->fetcher->getVehicleModelData($modelYear, $manufacturer, $modelName);

        $this->assertSame([], $modelData);
    }

    public function testGetVehicleModelDataSuccessValidResponseCode()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $expectedRequestUrl = sprintf(
            'https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/%s/make/%s/model/%s?format=json',
            $modelYear,
            $manufacturer,
            $modelName
        );

        $prepResponseCode = 200;
        $prepResponseBody = 'valid response body';
        $prepResponse = new Response($prepResponseCode, [], $prepResponseBody);
        $prepModelData = ['valid vehicle model data'];

        $this->apiClient->expects($this->once())
            ->method('request')
            ->with(
                $this->identicalTo('GET'),
                $this->identicalTo($expectedRequestUrl)
            )
            ->will($this->returnValue($prepResponse));

        $this->dataConverterFacade->expects($this->once())
            ->method('convertApiResponseToVehicleModelData')
            ->with($this->identicalTo($prepResponseBody))
            ->will($this->returnValue($prepModelData));

        $modelData = $this->fetcher->getVehicleModelData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepModelData, $modelData);
    }

    /**
     * Create mock for ClientInterface.
     *
     * @return ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createClientInterfaceMock()
    {
        return $this->getMockBuilder(ClientInterface::class)->getMock();
    }

    /**
     * Create mock for VehicleModelDataConverterFacadeInterface.
     *
     * @return VehicleModelDataConverterFacadeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleModelDataConverterFacadeInterfaceMock()
    {
        return $this->getMockBuilder(VehicleModelDataConverterFacadeInterface::class)->getMock();
    }
}
