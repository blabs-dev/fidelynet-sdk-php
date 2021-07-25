<?php

namespace Blabs\FidelyNet\Services;

use Blabs\FidelyNet\Constants\ApiServices;

final class BackofficeService extends ServiceAbstract
{
    /**
     * @inheritdoc
     */
    public $service_type = ApiServices::BACKOFFICE;
}
