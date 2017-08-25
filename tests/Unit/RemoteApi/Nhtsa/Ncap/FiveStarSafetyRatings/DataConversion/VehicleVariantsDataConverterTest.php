<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\VehicleVariantsDataConverter;

class VehicleVariantsDataConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleVariantsDataConverter
     */
    private $converter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->converter = new VehicleVariantsDataConverter();
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
     * @dataProvider provideConvertApiDataToVehicleVariantsDataData
     */
    public function testConvertApiDataToVehicleVariantsDataSuccess(array $apiData, array $expVariantsData)
    {
        $variantsData = $this->converter->convertApiDataToVehicleVariantsData($apiData);

        $this->assertSame($expVariantsData, $variantsData);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideConvertApiDataToVehicleVariantsDataData()
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
