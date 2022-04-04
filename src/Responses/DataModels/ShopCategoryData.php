<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class ShopCategoryData extends DataTransferObject
{
    public int $id;
    public int $fatherId;
    public string $description;

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromAttributes(int $id, int $fatherId, string $description): ShopCategoryData
    {
        return new self([
            'id' => $id,
            'fatherId' => $fatherId,
            'description' => $description
        ]);
    }
}