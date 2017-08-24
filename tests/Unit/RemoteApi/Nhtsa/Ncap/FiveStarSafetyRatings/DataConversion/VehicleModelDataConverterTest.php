<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleModelDataConverter;

class VehicleModelDataConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleModelDataConverter
     */
    private $converter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->converter = new VehicleModelDataConverter();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->converter = null;
    }

    /**
     * @param array $apiData
     * @param array $expVehicleModelData
     *
     * @dataProvider provideConvertApiDataToVehicleModelDataData
     */
    public function testConvertApiDataToVehicleModelDataSuccess(array $apiData, array $expVehicleModelData)
    {
        $vehicleModelData = $this->converter->convertApiDataToVehicleModelData($apiData);

        $this->assertSame($expVehicleModelData, $vehicleModelData);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideConvertApiDataToVehicleModelDataData()
    {
        return [
            'empty' => [
                [],
                [],
            ],
            'invalid - not an array' => [
                [
                    'not an array',
                ],
                [],
            ],
            'invalid - no VehicleDescription' => [
                [
                    [
                        'VehicleId' => 1234,
                    ],
                ],
                [],
            ],
            'invalid - no VehicleId' => [
                [
                    [
                        'VehicleDescription' => 'some description',
                    ],
                ],
                [],
            ],
            'valid - one entry' => [
                [
                    [
                        'VehicleDescription' => 'some description',
                        'VehicleId'          => 1234,
                    ],
                ],
                [
                    [
                        'Description' => 'some description',
                        'VehicleId'   => 1234,
                    ],
                ],
            ],
            'valid - two entries' => [
                [
                    [
                        'VehicleDescription' => 'some description',
                        'VehicleId'          => 1234,
                    ],
                    [
                        'VehicleDescription' => 'some other description',
                        'VehicleId'          => 1235,
                    ],
                ],
                [
                    [
                        'Description' => 'some description',
                        'VehicleId'   => 1234,
                    ],
                    [
                        'Description' => 'some other description',
                        'VehicleId'   => 1235,
                    ],
                ],
            ],
            'mixed - one valid entry' => [
                [
                    [
                        'VehicleDescription' => 'some description',
                        'VehicleId'          => 1234,
                    ],
                    [
                        'InvalidEntry' => 'not valid',
                    ],
                ],
                [
                    [
                        'Description' => 'some description',
                        'VehicleId'   => 1234,
                    ],
                ],
            ],
        ];
    }
}
