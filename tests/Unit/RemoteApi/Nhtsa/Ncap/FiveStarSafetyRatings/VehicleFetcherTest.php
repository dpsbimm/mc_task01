<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverterFacadeInterface;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleFetcher;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;

class VehicleFetcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $apiClient;

    /**
     * @var VehicleFetcher
     */
    private $fetcher;

    /**
     * @var VehicleDataConverterFacadeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $dataConverterFacade;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->apiClient = $this->createClientInterfaceMock();
        $this->dataConverterFacade = $this->createVehicleDataConverterFacadeInterfaceMock();

        $this->fetcher = new VehicleFetcher($this->apiClient, $this->dataConverterFacade);
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
        $vehicleId = '9400';

        $this->apiClient->expects($this->once())
            ->method('request')
            ->will($this->throwException(new TransferException()));

        $variantsData = $this->fetcher->getVehicleData($vehicleId);

        $this->assertSame([], $variantsData);
    }

    public function testGetVehicleVariantsDataSuccessInvalidResponseCode()
    {
        $vehicleId = '9400';

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

        $variantsData = $this->fetcher->getVehicleData($vehicleId);

        $this->assertSame([], $variantsData);
    }

    public function testGetVehicleVariantsDataSuccessValidResponseCode()
    {
        $vehicleId = '9400';

        $expectedRequestUrl = sprintf(
            'https://one.nhtsa.gov/webapi/api/SafetyRatings/VehicleId/%s?format=json',
            $vehicleId
        );

        $prepResponseCode = 200;
        $prepResponseBody = 'valid response body';
        $prepResponse = new Response($prepResponseCode, [], $prepResponseBody);
        $prepVariantsData = ['valid vehicle data'];

        $this->apiClient->expects($this->once())
            ->method('request')
            ->with(
                $this->identicalTo('GET'),
                $this->identicalTo($expectedRequestUrl)
            )
            ->will($this->returnValue($prepResponse));

        $this->dataConverterFacade->expects($this->once())
            ->method('convertApiResponseToVehicleData')
            ->with($this->identicalTo($prepResponseBody))
            ->will($this->returnValue($prepVariantsData));

        $variantsData = $this->fetcher->getVehicleData($vehicleId);

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
     * Create mock for VehicleDataConverterFacadeInterface.
     *
     * @return VehicleDataConverterFacadeInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleDataConverterFacadeInterfaceMock()
    {
        return $this->getMockBuilder(VehicleDataConverterFacadeInterface::class)->getMock();
    }
}
