<?php

namespace Blabs\FidelyNet\Responses\Lists;

use Blabs\FidelyNet\Constants\CardMovementConstants;
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
            'count'     => $response->recordsTotal,
            'movements' => array_map(
                function ($movement) {
                    $movementData = new MovementBackOfficeData($movement['movement']);
                    $movementData->kindDescription = CardMovementConstants::KIND_IDS_MAP[$movementData->kind];
                    return $movementData;
                },
                $response->data
            ),
        ]);
    }
}
