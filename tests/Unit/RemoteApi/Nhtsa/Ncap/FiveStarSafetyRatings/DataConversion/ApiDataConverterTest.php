<?php

namespace Tests\Unit\App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion;

use App\RemoteApi\Nhtsa\Ncap\FiveStarSafetyRatings\DataConversion\ApiDataConverter;

class ApiDataConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiDataConverter
     */
    private $converter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->converter = new ApiDataConverter();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->converter = null;
    }

    /**
     * @param string $apiResponse
     * @param array  $expectedApiData
     *
     * @dataProvider provideConvertApiResponseToApiDataData
     */
    public function testConvertApiResponseToApiDataSuccess($apiResponse, array $expectedApiData)
    {
        $apiData = $this->converter->convertApiResponseToApiData($apiResponse);

        $this->assertSame($expectedApiData, $apiData);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideConvertApiResponseToApiDataData()
    {
        return [
            'empty string' => [
                '',
                [],
            ],
            'invalid JSON' => [
                'not a JSON string',
                [],
            ],
            'valid' => [
                json_encode([
                    'Results' => ['some' => 'results'],
                ]),
                ['some' => 'results'],
            ],
            'valid JSON, no results' => [
                json_encode([
                    'NotResults' => 'results are missing',
                ]),
                [],
            ],
            'valid JSON, results are not an array' => [
                json_encode([
                    'Results' => 'not an array',
                ]),
                [],
            ],
        ];
    }
}
