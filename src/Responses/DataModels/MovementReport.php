<?php

namespace Blabs\FidelyNet\Responses\DataModels;

use Spatie\DataTransferObject\DataTransferObject;

class MovementReport extends DataTransferObject
{
//movementCount": 34204,
//            "customerCount": 23542,
//            "totalMoney": 10418.85,
//            "averageTicket": 0.305,
//            "chargedPoints": 47550.69,
//            "dischargedPoints": 415

    public int $movementCount;
    public int $customerCount;
    public float $totalMoney;
    public float $averageTicket;
    public float $chargedPoints;
    public float $dischargedPoints;
}