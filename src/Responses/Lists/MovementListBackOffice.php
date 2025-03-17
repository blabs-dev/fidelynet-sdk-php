<?php

namespace Blabs\FidelyNet\Responses\Lists;

use Blabs\FidelyNet\Constants\CardMovementConstants;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\DataModels\MovementBackOfficeData;
use Blabs\FidelyNet\Responses\DataModels\MovementReport;
use Blabs\FidelyNet\Responses\DataModels\PaginationData;

class MovementListBackOffice extends \Spatie\DataTransferObject\DataTransferObject
{
    public int $count;

    /** @var MovementBackOfficeData[] */
    public array $movements;

    public ?PaginationData $pagination;

    public ?MovementReport $report;

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

    public static function createFullListFromApiResponse(ApiResponse $response)
    {
        $data = $response->data;
        $report = new MovementReport($data['movementTotal']);
        $movements = $data['movements'];
        $pagination = new PaginationData($data['pagination']);

        return new self([
            'count'     => $report->movementCount ?? 0,
            'report'    => $report,
            'movements' => array_map(
                function ($movement) {
                    $movementData = new MovementBackOfficeData($movement['movement']);
                    $movementData->kindDescription = CardMovementConstants::KIND_IDS_MAP[$movementData->kind];

                    return $movementData;
                },
                $movements
            ),
            'pagination' => $pagination,
        ]);
    }
}
