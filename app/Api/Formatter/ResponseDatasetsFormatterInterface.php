<?php

namespace App\Api\Formatter;

interface ResponseDatasetsFormatterInterface
{
    /**
     * Format datasets for response.
     *
     * @param array $datasets
     *
     * @return array
     */
    public function formatDatasets(array $datasets);
}
