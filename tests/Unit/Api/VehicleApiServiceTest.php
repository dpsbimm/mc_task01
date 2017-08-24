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

        $this->setUpModelFetcherGetVehicleModelData($modelYear, $manufacturer, $modelName, $prepModelData);

        $this->setUpResponseFormatterFormatDatasets($prepModelData, $prepFormattedData);

        $result = $this->service->getVehicleModelData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepFormattedData, $result);
    }

    /**
     * @param array|null $modelData
     *
     * @dataProvider provideGetVehicleModelDataByArrayInvalidArrayData
     */
    public function testGetVehicleModelDataByArraySuccessInvalidArray($modelData)
    {
        $prepFormattedData = ['some formatted data'];

        $this->setUpResponseFormatterFormatDatasets([], $prepFormattedData);

        $result = $this->service->getVehicleModelDataByArray($modelData);

        $this->assertSame($prepFormattedData, $result);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideGetVehicleModelDataByArrayInvalidArrayData()
    {
        return [
            'null' => [
                null,
            ],
            'missing key "modelYear"' => [
                [
                    'manufacturer' => 'Manufacturer',
                    'model'        => 'Model',
                ],
            ],
            'missing key "manufacturer"' => [
                [
                    'modelYear'    => 2017,
                    'model'        => 'Model',
                ],
            ],
            'missing key "model"' => [
                [
                    'modelYear'    => 2017,
                    'manufacturer' => 'Manufacturer',
                ],
            ],
        ];
    }

    public function testGetVehicleModelDataByArraySuccessValidArray()
    {
        $modelData = [
            'modelYear'    => 2017,
            'manufacturer' => 'Manufacturer',
            'model'        => 'Model',
        ];

        $prepModelData = ['some vehicle model data'];
        $prepFormattedData = ['some formatted vehicle model data'];

        $this->setUpModelFetcherGetVehicleModelData(
            $modelData['modelYear'],
            $modelData['manufacturer'],
            $modelData['model'],
            $prepModelData
        );

        $this->setUpResponseFormatterFormatDatasets($prepModelData, $prepFormattedData);

        $result = $this->service->getVehicleModelDataByArray($modelData);

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

    /**
     * Set up model fetcher: getVehicleModelData.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     * @param array  $vehicleModelData
     */
    private function setUpModelFetcherGetVehicleModelData(
        $modelYear,
        $manufacturer,
        $modelName,
        array $vehicleModelData
    ) {
        $this->modelFetcher->expects($this->once())
            ->method('getVehicleModelData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($vehicleModelData));
    }

    /**
     *
     * Set up response formatter: formatDatasets.
     *
     * @param array $vehicleModelData
     * @param array $formattedModelData
     */
    private function setUpResponseFormatterFormatDatasets(array $vehicleModelData, array $formattedModelData)
    {
        $this->responseFormatter->expects($this->once())
            ->method('formatDatasets')
            ->with($this->identicalTo($vehicleModelData))
            ->will($this->returnValue($formattedModelData));
    }
}
