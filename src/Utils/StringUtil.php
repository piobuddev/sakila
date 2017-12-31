<?php declare(strict_types=1);

namespace Sakila\Utils;

class StringUtil
{
    /**
     * @param string    $value
     * @param string    $delimiter
     * @param bool|null $ucFirst
     *
     * @return string
     */
    public static function toCamelCase(
        string $value,
        string $delimiter = '_',
        bool $ucFirst = null
    ): string {
        $delimiter = preg_quote($delimiter);
        $result = preg_replace_callback(
            "#{$delimiter}([A-Za-z])#",
            function ($matches) {
                return ucfirst(array_pop($matches));
            },
            $value
        );

        return $ucFirst ? ucfirst($result) : $result;
    }

    /**
     * @param string    $value
     * @param string    $delimiter
     * @param bool|null $lcFirst
     *
     * @return string
     */
    public static function fromCamelCase(
        string $value,
        string $delimiter = '_',
        bool $lcFirst = null
    ): string {
        $result = preg_replace_callback(
            "#(?!^)[A-Z](?=[a-z]+)#",
            function (array $matches) use ($delimiter) {
                return $delimiter . strtolower(array_pop($matches));
            },
            $value
        );

        return null !== $lcFirst ? lcfirst($result) : $result;
    }

    /**
     * @param string $prefix
     * @param string $input
     * @param bool   $ucInput
     *
     * @return string
     */
    public static function prefix(
        string $prefix,
        string $input,
        bool $ucInput = true
    ): string {
        return $prefix . ($ucInput ? ucfirst($input) : $input);
    }
}
