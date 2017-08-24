<?php

namespace App\Api\Formatter;

class ResponseDatasetsFormatter implements ResponseDatasetsFormatterInterface
{
    /**
     * @inheritDoc
     */
    public function formatDatasets(array $datasets)
    {
        return [
            'Count'   => count($datasets),
            'Results' => $datasets,
        ];
    }
}
