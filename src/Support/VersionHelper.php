<?php

namespace Blabs\FidelyNet\Support;

final class VersionHelper
{
    public static function getCurrentVersion(): string
    {
        $composerJsonPath = self::getComposerJsonPath();
        $content = file_get_contents(($composerJsonPath));
        $composer_data = json_decode($content, true);

        return array_key_exists('version', $composer_data) ?
            $composer_data['version']
            : 'unknown version';
    }

    /**
     * @return string
     */
    private static function getComposerJsonPath(): string
    {
        return realpath($_SERVER['DOCUMENT_ROOT']) . '/composer.json';
    }
}
