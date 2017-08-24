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
            'found - 4 entries' => [
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
            'found - 2 entries' => [
                '2015',
                'Toyota',
                'Yaris',
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'Description' => '2015 Toyota Yaris 3 HB FWD',
                            'VehicleId'   => 9791
                        ],
                        [
                            'Description' => '2015 Toyota Yaris Liftback 5 HB FWD',
                            'VehicleId'   => 9146
                        ],
                    ],
                ],
            ],
            'not found - no results' => [
                '2015',
                'Ford',
                'Crown Victoria',
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'not found - invalid model year' => [
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
}
