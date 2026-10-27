<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Result of the `getcardfrombarcode` action: the campaign code and card number decoded from a barcode.
 */
final class BarcodeCardData extends DataTransferObject
{
    public int $campaignCode;

    public int $card;

    public string $barcode;

    public string $tmpBarcode;

    public static function fromApiData(array $data): self
    {
        return new self(
            campaignCode: (int) $data['campagna_code'],
            card: (int) $data['card'],
            barcode: (string) $data['barcode'],
            tmpBarcode: (string) ($data['tmpbarcode'] ?? ''),
        );
    }
}
