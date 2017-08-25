<?php

namespace Tests\Unit\App\Api;

use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\Api\VehicleApiService;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcherInterface;

class VehicleApiServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseDatasetsFormatterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $responseFormatter;

    /**
     * @var VehicleApiService
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
        $this->responseFormatter = $this->createResponseDatasetsFormatterInterfaceMock();
        $this->variantsFetcher = $this->createVehicleVariantsFetcherInterfaceMock();

        $this->service = new VehicleApiService($this->responseFormatter, $this->variantsFetcher);
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->service = null;
        $this->variantsFetcher = null;
        $this->responseFormatter = null;
    }

    public function testGetVehicleVariantsDataSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepVariantsData = ['some valid variants data'];
        $prepFormattedData = ['some formatted valid variants data'];

        $this->setUpVariantsFetcherGetVehicleVariantsData($modelYear, $manufacturer, $modelName, $prepVariantsData);

        $this->setUpResponseFormatterFormatDatasets($prepVariantsData, $prepFormattedData);

        $result = $this->service->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepFormattedData, $result);
    }

    /**
     * @param array|null $variantsData
     *
     * @dataProvider provideGetVehicleVariantsDataByArrayInvalidArrayData
     */
    public function testGetVehicleVariantsDataByArraySuccessInvalidArray($variantsData)
    {
        $prepFormattedData = ['some formatted data'];

        $this->setUpResponseFormatterFormatDatasets([], $prepFormattedData);

        $result = $this->service->getVehicleVariantsDataByArray($variantsData);

        $this->assertSame($prepFormattedData, $result);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideGetVehicleVariantsDataByArrayInvalidArrayData()
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

    public function testGetVehicleVariantsDataByArraySuccessValidArray()
    {
        $modelData = [
            'modelYear'    => 2017,
            'manufacturer' => 'Manufacturer',
            'model'        => 'Model',
        ];

        $prepVariantsData = ['some vehicle variants data'];
        $prepFormattedData = ['some formatted vehicle variants data'];

        $this->setUpVariantsFetcherGetVehicleVariantsData(
            $modelData['modelYear'],
            $modelData['manufacturer'],
            $modelData['model'],
            $prepVariantsData
        );

        $this->setUpResponseFormatterFormatDatasets($prepVariantsData, $prepFormattedData);

        $result = $this->service->getVehicleVariantsDataByArray($modelData);

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
     * Create mock for VehicleVariantsFetcherInterface.
     *
     * @return VehicleVariantsFetcherInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsFetcherInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsFetcherInterface::class)->getMock();
    }

    /**
     *
     * Set up response formatter: formatDatasets.
     *
     * @param array $variantsData
     * @param array $formattedData
     */
    private function setUpResponseFormatterFormatDatasets(array $variantsData, array $formattedData)
    {
        $this->responseFormatter->expects($this->once())
            ->method('formatDatasets')
            ->with($this->identicalTo($variantsData))
            ->will($this->returnValue($formattedData));
    }

    /**
     * Set up variants fetcher: getVehicleVariantsData.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     * @param array  $variantsData
     */
    private function setUpVariantsFetcherGetVehicleVariantsData(
        $modelYear,
        $manufacturer,
        $modelName,
        array $variantsData
    ) {
        $this->variantsFetcher->expects($this->once())
            ->method('getVehicleVariantsData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($variantsData));
    }
}
