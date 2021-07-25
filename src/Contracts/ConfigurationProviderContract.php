<?php


namespace Blabs\FidelyNet\Contracts;


interface ConfigurationProviderContract
{
    public function getOption($key, $parent_key = null);
}