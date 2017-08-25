<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverterFacadeInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcher;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;

class VehicleVariantsFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiClient;

    /**
     * @var VehicleVariantsFetcher
     */
    private $fetcher;

    /**
     * @var VehicleVariantsDataConverterFacadeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dataConverterFacade;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->apiClient = $this->createClientInterfaceMock();
        $this->dataConverterFacade = $this->createVehicleVariantsDataConverterFacadeInterfaceMock();

        $this->fetcher = new VehicleVariantsFetcher($this->apiClient, $this->dataConverterFacade);
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

    public function testGetVehicleVariantsDataSuccessConnectionOrRemoteError()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $this->apiClient->expects($this->once())
            ->method('request')
            ->will($this->throwException(new TransferException()));

        $variantsData = $this->fetcher->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $this->assertSame([], $variantsData);
    }

    public function testGetVehicleVariantsDataSuccessInvalidResponseCode()
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

        $variantsData = $this->fetcher->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $this->assertSame([], $variantsData);
    }

    public function testGetVehicleVariantsDataSuccessValidResponseCode()
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
        $prepVariantsData = ['valid vehicle variants data'];

        $this->apiClient->expects($this->once())
            ->method('request')
            ->with(
                $this->identicalTo('GET'),
                $this->identicalTo($expectedRequestUrl)
            )
            ->will($this->returnValue($prepResponse));

        $this->dataConverterFacade->expects($this->once())
            ->method('convertApiResponseToVehicleVariantsData')
            ->with($this->identicalTo($prepResponseBody))
            ->will($this->returnValue($prepVariantsData));

        $variantsData = $this->fetcher->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepVariantsData, $variantsData);
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
     * Create mock for VehicleVariantsDataConverterFacadeInterface.
     *
     * @return VehicleVariantsDataConverterFacadeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsDataConverterFacadeInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsDataConverterFacadeInterface::class)->getMock();
    }
}
