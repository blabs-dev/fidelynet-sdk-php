<?php

namespace Blabs\FidelyNet\Responses\Lists;

use Blabs\FidelyNet\Constants\CardMovementConstants;
use Blabs\FidelyNet\Responses\ApiResponse;
use Blabs\FidelyNet\Responses\DataModels\CustomerData;
use Blabs\FidelyNet\Responses\DataModels\CustomerInfoData;
use Blabs\FidelyNet\Responses\DataModels\MovementBackOfficeData;
use Blabs\FidelyNet\Responses\DataModels\MovementReport;
use Blabs\FidelyNet\Responses\DataModels\PaginationData;
use Spatie\DataTransferObject\DataTransferObject;

class CustomerListBackoffice extends DataTransferObject
{
    /** @var CustomerData[]  */
    public array $customers = [];

    public PaginationData $pagination;

    public static function createFromApiResponse(ApiResponse $response)
    {
        $data = $response->data;
        $customers = $data['customers'];
        $pagination = new PaginationData($data['pagination']);
        return new self([
            'customers' => array_map(fn ($customer )=> new CustomerInfoData($customer), $customers),
            'pagination' => $pagination
        ]);
    }
}