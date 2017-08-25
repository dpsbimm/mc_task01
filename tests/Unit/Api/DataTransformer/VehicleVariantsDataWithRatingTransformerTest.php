<?php

namespace Tests\Unit\App\Api\DataTransformer;

use App\Api\DataTransformer\VehicleVariantsDataWithRatingTransformer;

class VehicleVariantsDataWithRatingTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleVariantsDataWithRatingTransformer
     */
    private $transformer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->transformer = new VehicleVariantsDataWithRatingTransformer();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->transformer = null;
    }

    /**
     * @param array $variantsData
     * @param array $expTransformedData
     *
     * @dataProvider provideConvertApiDataToVehicleVariantsDataData
     */
    public function testConvertApiDataToVehicleVariantsDataSuccess(array $variantsData, array $expTransformedData)
    {
        $transformedData = $this->transformer->transformVehicleVariantsDataWithRating($variantsData);

        $this->assertSame($expTransformedData, $transformedData);
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
                    [
                        'CrashRating' => '5',
                        'Description' => 'some description',
                        'VehicleId'   => 1234,
                    ],
                ],
            ],
            'valid - two entries' => [
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
                [
                    [
                        'CrashRating' => '5',
                        'Description' => 'some description',
                        'VehicleId'   => 1234,
                    ],
                    [
                        'CrashRating' => 'Not Rated',
                        'Description' => 'some other description',
                        'VehicleId'   => 1235,
                    ],
                ],
            ],
            'mixed - one valid entry' => [
                [
                    [
                        'OverallRating'      => 'Not Rated',
                        'VehicleDescription' => 'some description',
                        'VehicleId'          => 1234,
                    ],
                    [
                        'InvalidEntry' => 'not valid',
                    ],
                ],
                [
                    [
                        'CrashRating' => 'Not Rated',
                        'Description' => 'some description',
                        'VehicleId'   => 1234,
                    ],
                ],
            ],
        ];
    }
}
