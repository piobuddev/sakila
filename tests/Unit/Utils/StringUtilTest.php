<?php declare(strict_types=1);

namespace Sakila\Test\Utils;

use Sakila\Test\AbstractUnitTestCase;
use Sakila\Utils\StringUtil;

class StringUtilTest extends AbstractUnitTestCase
{
    /**
     * @dataProvider stringsDataProvider
     *
     * @param string    $input
     * @param string    $delimiter
     * @param string    $output
     * @param bool|null $ucFirst
     */
    public function testConvertsToCamelCase(
        string $input,
        string $delimiter,
        string $output,
        bool $ucFirst = null
    ): void {
        $this->assertEquals($output, StringUtil::toCamelCase($input, $delimiter, $ucFirst));
    }

    /**
     * @dataProvider stringsDataProvider
     *
     * @param string    $output
     * @param string    $delimiter
     * @param string    $input
     * @param bool|null $lcFirst
     */
    public function testConvertsFromCamelCase(
        string $output,
        string $delimiter,
        string $input,
        bool $lcFirst = null
    ): void {
        $this->assertEquals($output, StringUtil::fromCamelCase($input, $delimiter, $lcFirst));
    }

    /**
     * @return array
     */
    public function stringsDataProvider(): array
    {
        return [
            ['foo_bar_baz', '_', 'fooBarBaz'],
            ['foo-bar-baz', '-', 'fooBarBaz'],
            ['foo.bar.baz', '.', 'FooBarBaz', true],
            ['FOO.bar.baz', '.', 'FOOBarBaz'],
        ];
    }

    public function testAddPrefix(): void
    {
        $prefix = 'bar';
        $string = 'Foo';

        $this->assertEquals('barFoo', StringUtil::prefix($prefix, $string));
    }
}
