<?php

namespace Blabs\FidelyNet\Test\DataModels;

use Blabs\FidelyNet\Responses\DataModels\MovementBackOfficeData;
use PHPUnit\Framework\TestCase;

class MovementBackOfficeDataTest extends TestCase
{
    /**
     * FidelyNet returns null on customerName/customerSurname for some movements
     * (e.g. anonymized customers). The DTO must accept null on both fields.
     */
    public function test_accepts_null_customer_name_and_surname(): void
    {
        $movement = new MovementBackOfficeData([
            'id' => 1,
            'campaign' => 1,
            'terminal' => 0,
            'shopId' => 0,
            'card' => 1,
            'cardOld' => '',
            'kind' => 1,
            'kindDescription' => null,
            'customer' => 1,
            'customerName' => null,
            'customerSurname' => null,
            'operatorId' => 0,
            'dateTime' => '2026-01-01T00:00:00.000+02:00',
            'localTime' => '2026-01-01T02:00:00.000+02:00',
            'chargedCredits' => 0.0,
            'chargedGiftCredits' => 0.0,
            'chargedPoints' => 0.0,
            'chargedPointsStatus' => 0,
            'dischargedCredits' => 0.0,
            'dischargedGiftCredits' => 0.0,
            'dischargedPoints' => 0.0,
            'dischargedPointsStatus' => 0,
            'currencyConversion' => 0,
            'profitMoneyLocal' => 0,
            'totalMoney' => 0.0,
            'totalBenefits' => 0,
            'discount' => 0,
            'paymentMethodId' => 0,
            'kindCharge' => null,
            'promotionErrorCode' => null,
            'sellerId' => null,
        ]);

        $this->assertNull($movement->customerName);
        $this->assertNull($movement->customerSurname);
    }
}
