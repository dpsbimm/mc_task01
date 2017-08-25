<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleDataConverter;

class VehicleDataConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleDataConverter
     */
    private $converter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->converter = new VehicleDataConverter();
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
     * @param array $expVariantsData
     *
     * @dataProvider provideConvertApiDataToVehicleDataData
     */
    public function testConvertApiDataToVehicleDataSuccess(array $apiData, array $expVariantsData)
    {
        $vehicleData = $this->converter->convertApiDataToVehicleData($apiData);

        $this->assertSame($expVariantsData, $vehicleData);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideConvertApiDataToVehicleDataData()
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
            'invalid - no OverallRating' => [
                [
                    [
                        'VehicleId'          => 1234,
                        'VehicleDescription' => 'some description',
                    ],
                ],
                [],
            ],
            'invalid - no VehicleDescription' => [
                [
                    [
                        'OverallRating'      => '5',
                        'VehicleId'          => 1234,
                    ],
                ],
                [],
            ],
            'invalid - no VehicleId' => [
                [
                    [
                        'OverallRating'      => '5',
                        'VehicleDescription' => 'some description',
                    ],
                ],
                [],
            ],
            'valid - one entry' => [
                [
                    [
                        'OverallRating'      => '5',
                        'VehicleDescription' => 'some description',
                        'VehicleId'          => 1234,
                    ],
                ],
                [
                    'OverallRating'      => '5',
                    'VehicleDescription' => 'some description',
                    'VehicleId'          => 1234,
                ],
            ],
            'invalid - more than one entry (2)' => [
                [
                    [
                        'OverallRating'      => '5',
                        'VehicleDescription' => 'some description',
                        'VehicleId'          => 1234,
                    ],
                    [
                        'OverallRating'      => 'Not Rated',
                        'VehicleDescription' => 'some other description',
                        'VehicleId'          => 1235,
                    ],
                ],
                [],
            ],
        ];
    }
}
