<?php

namespace Blabs\FidelyNet\Test\Support;

use Blabs\FidelyNet\Support\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    /**
     * @dataProvider missingRequiredOptionsProvider
     *
     * @param array $expectedMissingOptions
     * @param array $requiredOptions
     * @param array $inputOptions
     */
    public function test_missing_required_options_are_collected(array $expectedMissingOptions, array $requiredOptions, array $inputOptions)
    {
        $this->assertEquals($expectedMissingOptions, Arr::getMissingRequiredOptions($requiredOptions, $inputOptions));
    }

    public function missingRequiredOptionsProvider(): array
    {
        return [
            'missing some options' => [
                ['a', 'b'],
                ['a', 'b', 'c', 'd', 'e'],
                [
                    'c' => 'value c',
                    'd' => 'value d',
                    'e' => 'value e',
                ],
            ],
            'missing all options' => [
                ['a', 'b', 'c', 'd', 'e'],
                ['a', 'b', 'c', 'd', 'e'],
                [
                    'f' => 'value f',
                    'g' => 'value g',
                    'h' => 'value h',
                ],
            ],
            'no missing options' => [
                [],
                ['a', 'b', 'c', 'd', 'e'],
                [
                    'a' => 'value a',
                    'b' => 'value b',
                    'c' => 'value c',
                    'd' => 'value d',
                    'e' => 'value e',
                ],
            ],
        ];
    }

    /**
     * @dataProvider wrapListProvider
     *
     * @param array $expected
     * @param mixed $value
     */
    public function test_wrap_list_normalizes_service_lists(array $expected, $value)
    {
        $this->assertSame($expected, Arr::wrapList($value));
    }

    public function wrapListProvider(): array
    {
        $first = ['id' => 1, 'fatherId' => 0, 'description' => 'first'];
        $second = ['id' => 2, 'fatherId' => 0, 'description' => 'second'];

        return [
            'list of many elements' => [[$first, $second], [$first, $second]],
            'list of one element'   => [[$first], [$first]],
            'single object'         => [[$first], $first],
            'empty list'            => [[], []],
            'missing value'         => [[], null],
            'scalar value'          => [[], ''],
        ];
    }
}
