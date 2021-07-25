<?php

namespace Blabs\FidelyNet\Support;

final class Arr
{
    /**
     * Checks an array of key,value pairs against another array with a set of "required" keys.
     *
     * @param array $required_keys
     * @param array $options
     *
     * @return array
     */
    public static function getMissingRequiredOptions(array $required_keys, array $options): array
    {
        $missing_options = [];
        foreach ($required_keys as $required_key) {
            if (!array_key_exists($required_key, $options)) {
                $missing_options[] = $required_key;
            }
        }

        return $missing_options;
    }
}
