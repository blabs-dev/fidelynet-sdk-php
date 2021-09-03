<?php

namespace Blabs\FidelyNet\Test\Support;

use Blabs\FidelyNet\Support\VersionHelper;
use PHPUnit\Framework\TestCase;

class VersioningHelperTest extends TestCase
{
    public function test_version_number_respects_semantic_versioning()
    {
        $currentVersion = VersionHelper::getCurrentVersion();
        $this->assertTrue(
            (bool) preg_match(
                '/^((([0-9]+)\.([0-9]+)\.([0-9]+)(?:-([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)$/',
                $currentVersion
            )
        );
    }
}