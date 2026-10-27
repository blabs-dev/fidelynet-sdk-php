<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Customer as returned by the WEB POS actions (`getinfobycard`, `newcard`, `cancellasttransaction`, `getlastmovements`).
 *
 * Balances are floats: credits and points can be decimal. The full customer payload is kept in `raw`.
 */
final class WebPosCustomerData extends DataTransferObject
{
    public int $id;

    public ?int $campaignId;

    public ?string $campaignName;

    public ?string $card;

    public int|string|null $fidelyCode;

    public ?int $status;

    public ?string $issuedDate;

    public ?int $registrationShopId;

    public ?int $registrationNetId;

    public ?int $categoryId;

    public ?float $balancePoints;

    public ?float $balanceCredits;

    public ?float $balanceGiftCredits;

    public array $raw;

    public static function fromApiData(array $data): self
    {
        $balance = $data['balanceData'] ?? [];

        return new self(
            id: (int) ($data['id'] ?? 0),
            campaignId: self::nullableInt($data['campaignId'] ?? null),
            campaignName: $data['campaignName'] ?? null,
            card: isset($data['card']) ? (string) $data['card'] : null,
            fidelyCode: $data['fidelyCode'] ?? null,
            status: self::nullableInt($data['status'] ?? null),
            issuedDate: $data['issuedDate'] ?? null,
            registrationShopId: self::nullableInt($data['registration_shop_id'] ?? null),
            registrationNetId: self::nullableInt($data['registration_net_id'] ?? null),
            categoryId: self::nullableInt($balance['category'] ?? null),
            balancePoints: self::nullableFloat($balance['balance_points'] ?? null),
            balanceCredits: self::nullableFloat($balance['balance_credits'] ?? null),
            balanceGiftCredits: self::nullableFloat($balance['balance_gift_credits'] ?? null),
            raw: $data,
        );
    }

    private static function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' ? null : (int) $value;
    }

    private static function nullableFloat(mixed $value): ?float
    {
        return $value === null || $value === '' ? null : (float) $value;
    }
}
