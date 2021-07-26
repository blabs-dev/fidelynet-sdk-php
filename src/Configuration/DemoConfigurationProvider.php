<?php

namespace Blabs\FidelyNet\Configuration;

use Blabs\FidelyNet\Constants\ApiDemoData;
use Blabs\FidelyNet\Constants\ApiServices;
use Blabs\FidelyNet\Constants\ApiSessionTypes;
use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Contracts\ConfigurationProviderContract;
use Blabs\FidelyNet\Providers\SessionId\InMemorySessionIdProvider;

class DemoConfigurationProvider implements ConfigurationProviderContract
{
    private array $options = [
        ApiServices::CUSTOMER => [
            FactoryOptions::USERNAME    => ApiDemoData::CUSTOMER_USERNAME,
            FactoryOptions::PASSWORD    => ApiDemoData::CUSTOMER_PASSWORD,
            FactoryOptions::CAMPAIGN_ID => ApiDemoData::CAMPAIGN_ID,
        ],
        ApiServices::TERMINAL => [
            FactoryOptions::USERNAME => ApiDemoData::TERMINAL_USERNAME,
            FactoryOptions::PASSWORD => ApiDemoData::TERMINAL_PASSWORD,
            FactoryOptions::TERMINAL => ApiDemoData::TERMINAL_SERIAL,
        ],
        ApiServices::BACKOFFICE => [
            FactoryOptions::USERNAME => ApiDemoData::BACKOFFICE_USER,
            FactoryOptions::PASSWORD => ApiDemoData::BACKOFFICE_PASSWORD,
        ],
        FactoryOptions::DEMO_MODE           => true,
        FactoryOptions::SESSION_ID_PROVIDER => InMemorySessionIdProvider::class,
        FactoryOptions::SESSION_TYPE        => ApiSessionTypes::PRIVATE,
        FactoryOptions::HTTP_CLIENT         => null,
        FactoryOptions::START_SESSION       => true,
    ];

    public function getOption($key, $parent_key = null): ?string
    {
        if (!$parent_key) {
            return $this->options[$key];
        } else {
            return $this->options[$parent_key][$key];
        }
    }
}
