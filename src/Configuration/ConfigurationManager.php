<?php

namespace Blabs\FidelyNet\Configuration;

use Blabs\FidelyNet\Constants\FactoryOptions;
use Blabs\FidelyNet\Contracts\ConfigurationProviderContract;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;

class ConfigurationManager
{
    /** @var ConfigurationProviderContract */
    protected ConfigurationProviderContract $configurationProvider;

    private array $options;

    /**
     * ConfigurationManagerAbstract constructor.
     *
     * @param ConfigurationProviderContract $configurationProvider
     */
    public function __construct(ConfigurationProviderContract $configurationProvider)
    {
        $this->configurationProvider = $configurationProvider;
        $this->setupOptions();
    }

    private function setupOptions(): void
    {
        foreach (FactoryOptions::SCHEMA as $key => $value) {
            if (!is_numeric($key)) {
                foreach ($value as $sub_key) {
//                    var_dump(['chiave parent' => $key, 'valore' => $sub_key]);
                    $this->options[$key][$sub_key] = $this->configurationProvider->getOption($sub_key, $key);
                }
            } else {
                $this->options[$value] = $this->configurationProvider->getOption($value);
            }
        }
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->options));
        foreach ($iterator as $key => $entry) {
            $options[$key] = $entry;
        }

        $options[FactoryOptions::SESSION_ID_PROVIDER] = new $options[FactoryOptions::SESSION_ID_PROVIDER]();
//        $options[FactoryOptions::HTTP_CLIENT] = new $options[FactoryOptions::HTTP_CLIENT];

        return $options;
    }
}
