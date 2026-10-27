<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Movement as returned by the WEB POS actions. Amounts are floats (never cast to int).
 * The full movement payload is kept in `raw`.
 */
final class WebPosMovementData extends DataTransferObject
{
    public int $id;

    public int $kind;

    public ?int $shopId;

    public ?int $netId;

    public ?int $terminal;

    public ?int $card;

    public ?int $customer;

    public ?string $dateTime;

    public float $totalMoney;

    public float $chargedPoints;

    public float $dischargedPoints;

    public float $chargedCredits;

    public float $dischargedCredits;

    public array $raw;

    public static function fromApiData(array $data): self
    {
        $int = fn (string $key): ?int => isset($data[$key]) && $data[$key] !== '' ? (int) $data[$key] : null;

        return new self(
            id: (int) $data['id'],
            kind: (int) $data['kind'],
            shopId: $int('shopId'),
            netId: $int('netId'),
            terminal: $int('terminal'),
            card: $int('card'),
            customer: $int('customer'),
            dateTime: $data['dateTime'] ?? null,
            totalMoney: (float) ($data['totalMoney'] ?? 0),
            chargedPoints: (float) ($data['chargedPoints'] ?? 0),
            dischargedPoints: (float) ($data['dischargedPoints'] ?? 0),
            chargedCredits: (float) ($data['chargedCredits'] ?? 0),
            dischargedCredits: (float) ($data['dischargedCredits'] ?? 0),
            raw: $data,
        );
    }
}
