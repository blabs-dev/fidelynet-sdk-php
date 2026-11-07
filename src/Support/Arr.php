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

    /**
     * Normalizes a list returned by FidelyNET. When a list holds a single element the service
     * drops the list level and returns the element itself (an associative array): it is wrapped
     * back in a list. A missing or empty value becomes an empty list, a list is left untouched.
     *
     * @param mixed $value
     *
     * @return array
     */
    public static function wrapList($value): array
    {
        if (!is_array($value) || $value === []) {
            return [];
        }

        return array_keys($value) === range(0, count($value) - 1) ? $value : [$value];
    }
}
