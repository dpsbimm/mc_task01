<?php

namespace Tests\Unit\App\Api\Formatter;

use App\Api\Formatter\ResponseDatasetsFormatter;

class ResponseDatasetsFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseDatasetsFormatter
     */
    private $formatter;

    /**
     * PHPUnit: setUp.
     */
    public function setUp()
    {
        $this->formatter = new ResponseDatasetsFormatter();
    }

    /**
     * PHPUnit: tearDown.
     */
    public function tearDown()
    {
        $this->formatter = null;
    }

    /**
     * @param array $datasets
     * @param array $expectedDatasets
     *
     * @dataProvider provideFormatDatasetsData
     */
    public function testFormatDatasetsSuccess(array $datasets, array $expectedDatasets)
    {
        $formattedDatasets = $this->formatter->formatDatasets($datasets);

        $this->assertSame($expectedDatasets, $formattedDatasets);
    }

    /**
     * Data provider.
     *
     * @return array
     */
    public function provideFormatDatasetsData()
    {
        return [
            'empty' => [
                [],
                [
                    'Count'   => 0,
                    'Results' => [],
                ],
            ],
            'one' => [
                ['dataset'],
                [
                    'Count'   => 1,
                    'Results' => [
                        'dataset',
                    ],
                ],
            ],
            'two' => [
                [
                    [
                        'actual' => 'dataset',
                        'even'   => 'multiple_attributes',
                    ],
                    [
                        'another' => 'one',
                    ],
                ],
                [
                    'Count'   => 2,
                    'Results' => [
                        [
                            'actual' => 'dataset',
                            'even'   => 'multiple_attributes',
                        ],
                        [
                            'another' => 'one',
                        ],
                    ],
                ],
            ],
        ];
    }
}
