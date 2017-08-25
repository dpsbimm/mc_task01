<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    /**
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $model
     * @param array  $expectedResponse
     *
     * @dataProvider provideShowModelsData
     */
    public function testShowModelsSuccess($modelYear, $manufacturer, $model, array $expectedResponse)
    {
        $url = sprintf('/vehicles/%s/%s/%s', $modelYear, $manufacturer, $model);

        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertExactJson($expectedResponse);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideShowModelsData()
    {
        return [
            'case 1 - found - 4 entries' => [
                '2015',
                'Audi',
                'A3',
                [
                    'Count'   => 4,
                    'Results' => [
                        [
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId'   => 9403,
                        ],
                        [
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId'   => 9408,
                        ],
                        [
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId'   => 9405,
                        ],
                        [
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId'   => 9406,
                        ],
                    ],
                ],
            ],
            'case 2 - found - 2 entries' => [
                '2015',
                'Toyota',
                'Yaris',
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'Description' => '2015 Toyota Yaris 3 HB FWD',
                            'VehicleId'   => 9791,
                        ],
                        [
                            'Description' => '2015 Toyota Yaris Liftback 5 HB FWD',
                            'VehicleId'   => 9146,
                        ],
                    ],
                ],
            ],
            'case 3 - not found - no results' => [
                '2015',
                'Ford',
                'Crown Victoria',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 4 - not found - invalid model year' => [
                'undefined',
                'Ford',
                'Fusion',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
        ];
    }

    /**
     * @param string $modelYear
     * @param string $manufacturer
     * @param string $model
     * @param string $withRating
     * @param array $expectedResponse
     *
     * @dataProvider provideShowModelsWithRatingData
     */
    public function testShowModelsSuccessWithRating(
        $modelYear,
        $manufacturer,
        $model,
        $withRating,
        array $expectedResponse
    ) {
        $url = sprintf('/vehicles/%s/%s/%s?withRating=%s', $modelYear, $manufacturer, $model, $withRating);

        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertExactJson($expectedResponse);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideShowModelsWithRatingData()
    {
        return [
            'case 1.1 - withRating = "true" - found - 4 entries - with rating' => [
                '2015',
                'Audi',
                'A3',
                'true',
                [
                    'Count'   => 4,
                    'Results' => [
                        [
                            'CrashRating' => '5',
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId'   => 9403,
                        ],
                        [
                            'CrashRating' => '5',
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId'   => 9408,
                        ],
                        [
                            'CrashRating' => 'Not Rated',
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId'   => 9405,
                        ],
                        [
                            'CrashRating' => 'Not Rated',
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId'   => 9406,
                        ],
                    ],
                ],
            ],
            'case 1.2 - withRating = "false" - found - 4 entries - no rating' => [
                '2015',
                'Audi',
                'A3',
                'false',
                [
                    'Count'   => 4,
                    'Results' => [
                        [
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId'   => 9403,
                        ],
                        [
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId'   => 9408,
                        ],
                        [
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId'   => 9405,
                        ],
                        [
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId'   => 9406,
                        ],
                    ],
                ],
            ],
            'case 1.3 - withRating = "bananas" - found - 4 entries - no rating' => [
                '2015',
                'Audi',
                'A3',
                'bananas',
                [
                    'Count'   => 4,
                    'Results' => [
                        [
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId'   => 9403,
                        ],
                        [
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId'   => 9408,
                        ],
                        [
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId'   => 9405,
                        ],
                        [
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId'   => 9406,
                        ],
                    ],
                ],
            ],
            'case 2.1 - withRating = "true" - found - 2 entries - with rating' => [
                '2015',
                'Toyota',
                'Yaris',
                'true',
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'CrashRating' => 'Not Rated',
                            'Description' => '2015 Toyota Yaris 3 HB FWD',
                            'VehicleId'   => 9791,
                        ],
                        [
                            'CrashRating' => '4',
                            'Description' => '2015 Toyota Yaris Liftback 5 HB FWD',
                            'VehicleId'   => 9146,
                        ],
                    ],
                ],
            ],
            'case 2.2 - withRating = "false" - found - 2 entries - no rating' => [
                '2015',
                'Toyota',
                'Yaris',
                'false',
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'Description' => '2015 Toyota Yaris 3 HB FWD',
                            'VehicleId'   => 9791,
                        ],
                        [
                            'Description' => '2015 Toyota Yaris Liftback 5 HB FWD',
                            'VehicleId'   => 9146,
                        ],
                    ],
                ],
            ],
            'case 2.3 - withRating = "bananas" - found - 2 entries - no rating' => [
                '2015',
                'Toyota',
                'Yaris',
                'bananas',
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'Description' => '2015 Toyota Yaris 3 HB FWD',
                            'VehicleId'   => 9791,
                        ],
                        [
                            'Description' => '2015 Toyota Yaris Liftback 5 HB FWD',
                            'VehicleId'   => 9146,
                        ],
                    ],
                ],
            ],
            'case 3.1 - withRating = "true" - not found - no results' => [
                '2015',
                'Ford',
                'Crown Victoria',
                'true',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 3.2 - withRating = "false" - not found - no results' => [
                '2015',
                'Ford',
                'Crown Victoria',
                'false',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 3.3 - withRating = "bananas" - not found - no results' => [
                '2015',
                'Ford',
                'Crown Victoria',
                'bananas',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 4.1 - withRating = "true" - not found - invalid model year' => [
                'undefined',
                'Ford',
                'Fusion',
                'true',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 4.2 - withRating = "false" - not found - invalid model year' => [
                'undefined',
                'Ford',
                'Fusion',
                'false',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 4.3 - withRating = "bananas" - not found - invalid model year' => [
                'undefined',
                'Ford',
                'Fusion',
                'bananas',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
        ];
    }

    /**
     * @param array $requestData
     * @param array $expectedResponse
     *
     * @dataProvider provideShowModelsPostData
     */
    public function testShowModelsPostSuccess(array $requestData, array $expectedResponse)
    {
        $response = $this->json('POST', '/vehicles', $requestData);

        $response->assertStatus(200)
            ->assertExactJson($expectedResponse);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideShowModelsPostData()
    {
        return [
            'case 3 - invalid request - missing model year' => [
                [
                    'manufacturer' => 'Honda',
                    'model'        => 'Accord',
                ],
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'invalid request - missing manufacturer' => [
                [
                    'modelYear'    => 2015,
                    'model'        => 'A3',
                ],
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'invalid request - missing model name' => [
                [
                    'modelYear'    => 2015,
                    'manufacturer' => 'Audi',
                ],
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'case 1 - found - 4 entries' => [
                [
                    'modelYear'    => 2015,
                    'manufacturer' => 'Audi',
                    'model'        => 'A3',
                ],
                [
                    'Count'   => 4,
                    'Results' => [
                        [
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId'   => 9403,
                        ],
                        [
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId'   => 9408,
                        ],
                        [
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId'   => 9405,
                        ],
                        [
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId'   => 9406,
                        ],
                    ],
                ],
            ],
            'case 2 - found - 2 entries' => [
                [
                    'modelYear'    => 2015,
                    'manufacturer' => 'Toyota',
                    'model'        => 'Yaris',
                ],
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'Description' => '2015 Toyota Yaris 3 HB FWD',
                            'VehicleId'   => 9791,
                        ],
                        [
                            'Description' => '2015 Toyota Yaris Liftback 5 HB FWD',
                            'VehicleId'   => 9146,
                        ],
                    ],
                ],
            ],
        ];
    }
}
