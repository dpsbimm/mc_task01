<?php

namespace Tests\Unit\App\Api;

use App\Api\DataTransformer\VehicleVariantsDataTransformerInterface;
use App\Api\DataTransformer\VehicleVariantsDataWithRatingTransformerInterface;
use App\Api\Formatter\ResponseDatasetsFormatterInterface;
use App\Api\VehicleApiService;
use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\VehicleVariantsFetcherInterface;
use App\Vehicle\VehicleServiceInterface;
use App\Vehicle\VehicleVariantsServiceInterface;

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
    private $variantsService;

    /**
     * @var VehicleVariantsDataTransformerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $variantsTransformer;

    /**
     * @var VehicleVariantsDataWithRatingTransformerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $variantsWithRatingTransformer;

    /**
     * @var VehicleServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $vehicleService;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->responseFormatter = $this->createResponseDatasetsFormatterInterfaceMock();
        $this->variantsService = $this->createVehicleVariantsServiceInterfaceMock();
        $this->variantsTransformer = $this->createVehicleVariantsDataTransformerInterfaceMock();
        $this->variantsWithRatingTransformer = $this->createVehicleVariantsDataWithRatingTransformerInterfaceMock();
        $this->vehicleService = $this->createVehicleServiceInterfaceMock();

        $this->service = new VehicleApiService(
            $this->responseFormatter,
            $this->variantsService,
            $this->variantsTransformer,
            $this->variantsWithRatingTransformer,
            $this->vehicleService
        );
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->service = null;
        $this->vehicleService = null;
        $this->variantsWithRatingTransformer = null;
        $this->variantsService = null;
        $this->variantsTransformer = null;
        $this->responseFormatter = null;
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
        $prepTransformedData = ['some transformed variants data'];
        $prepFormattedData = ['some formatted vehicle variants data'];

        $this->setUpVariantsServiceGetVehicleVariantsData(
            $modelData['modelYear'],
            $modelData['manufacturer'],
            $modelData['model'],
            $prepVariantsData
        );

        $this->setUpVariantsTransformerTransformVehicleVariantsData($prepVariantsData, $prepTransformedData);

        $this->setUpResponseFormatterFormatDatasets($prepTransformedData, $prepFormattedData);

        $result = $this->service->getVehicleVariantsDataByArray($modelData);

        $this->assertSame($prepFormattedData, $result);
    }

    public function testGetVehicleVariantsDataSuccess()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';

        $prepVariantsData = ['some valid variants data'];
        $prepTransformedData = ['some transformed variants data'];
        $prepFormattedData = ['some formatted variants data'];

        $this->setUpVariantsServiceGetVehicleVariantsData($modelYear, $manufacturer, $modelName, $prepVariantsData);

        $this->setUpVariantsTransformerTransformVehicleVariantsData($prepVariantsData, $prepTransformedData);

        $this->setUpResponseFormatterFormatDatasets($prepTransformedData, $prepFormattedData);

        $result = $this->service->getVehicleVariantsData($modelYear, $manufacturer, $modelName);

        $this->assertSame($prepFormattedData, $result);
    }

    public function testGetVehicleVariantsDataSuccessWithRating()
    {
        $modelYear = '2017';
        $manufacturer = 'Manufacturer';
        $modelName = 'Model';
        $withRating = 'true';

        $prepVehicleIds = [1234, 1235];
        $prepVariantsData = [
            [
                'VehicleId' => $prepVehicleIds[0],
            ],
            [
                'VehicleId' => $prepVehicleIds[1],
            ],
        ];
        $prepVehicleDatasets = [
            ['the replaced'],
            ['datasets'],
        ];
        $prepTransformedData = ['some transformed variants data'];
        $prepFormattedData = ['some formatted variants data'];

        $this->setUpVariantsServiceGetVehicleVariantsData($modelYear, $manufacturer, $modelName, $prepVariantsData);

        $this->vehicleService->expects($this->exactly(count($prepVehicleDatasets)))
            ->method('getVehicleData')
            ->withConsecutive(
                [$this->identicalTo($prepVehicleIds[0])],
                [$this->identicalTo($prepVehicleIds[1])]
            )
            ->willReturnOnConsecutiveCalls(
                $prepVehicleDatasets[0],
                $prepVehicleDatasets[1]
            );

        $this->variantsWithRatingTransformer->expects($this->once())
            ->method('transformVehicleVariantsDataWithRating')
            ->with($this->identicalTo($prepVehicleDatasets))
            ->will($this->returnValue($prepTransformedData));

        $this->setUpResponseFormatterFormatDatasets($prepTransformedData, $prepFormattedData);

        $result = $this->service->getVehicleVariantsData($modelYear, $manufacturer, $modelName, $withRating);

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
     * Create mock for VehicleServiceInterface.
     *
     * @return VehicleServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleServiceInterfaceMock()
    {
        return $this->getMockBuilder(VehicleServiceInterface::class)->getMock();
    }

    /**
     * Create mock for VehicleVariantsDataTransformerInterface.
     *
     * @return VehicleVariantsDataTransformerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsDataTransformerInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsDataTransformerInterface::class)->getMock();
    }

    /**
     * Create mock for VehicleVariantsDataWithRatingTransformerInterface.
     *
     * @return VehicleVariantsDataWithRatingTransformerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsDataWithRatingTransformerInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsDataWithRatingTransformerInterface::class)->getMock();
    }

    /**
     * Create mock for VehicleVariantsServiceInterface.
     *
     * @return VehicleVariantsServiceInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createVehicleVariantsServiceInterfaceMock()
    {
        return $this->getMockBuilder(VehicleVariantsServiceInterface::class)->getMock();
    }

    /**
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
     * Set up variants service: getVehicleVariantsData.
     *
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $modelName
     * @param array  $variantsData
     */
    private function setUpVariantsServiceGetVehicleVariantsData(
        $modelYear,
        $manufacturer,
        $modelName,
        array $variantsData
    ) {
        $this->variantsService->expects($this->once())
            ->method('getVehicleVariantsData')
            ->with(
                $this->identicalTo($modelYear),
                $this->identicalTo($manufacturer),
                $this->identicalTo($modelName)
            )
            ->will($this->returnValue($variantsData));
    }

    /**
     * Set up variants transformer: transformVehicleVariantsData.
     *
     * @param array $prepVariantsData
     * @param array $prepTransformedData
     */
    private function setUpVariantsTransformerTransformVehicleVariantsData(
        array $prepVariantsData,
        array $prepTransformedData
    ) {
        $this->variantsTransformer->expects($this->once())
            ->method('transformVehicleVariantsData')
            ->with($this->identicalTo($prepVariantsData))
            ->will($this->returnValue($prepTransformedData));
    }
}
