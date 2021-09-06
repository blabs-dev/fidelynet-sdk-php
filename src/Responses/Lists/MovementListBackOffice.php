<?php

namespace Blabs\FidelyNet\Responses\Lists;

use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\DataModels\MovementBackOfficeData;

class MovementListBackOffice extends \Spatie\DataTransferObject\DataTransferObject
{
    public int $count;

    /** @var MovementBackOfficeData[] */
    public array $movements;

    public static function createFromApiResponse(ApiResponse $response)
    {
        return new self([
            'count' => $response->recordsTotal,
            'movements' => array_map(fn($movement) => new MovementBackOfficeData($movement),$response->data)
        ]);
    }
}