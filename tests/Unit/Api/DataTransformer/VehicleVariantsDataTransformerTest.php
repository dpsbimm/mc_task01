<?php

namespace Tests\Unit\App\Api\DataTransformer;

use App\Api\DataTransformer\VehicleVariantsDataTransformer;

class VehicleVariantsDataTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VehicleVariantsDataTransformer
     */
    private $transformer;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->transformer = new VehicleVariantsDataTransformer();
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
        $transformedData = $this->transformer->transformVehicleVariantsData($variantsData);

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
