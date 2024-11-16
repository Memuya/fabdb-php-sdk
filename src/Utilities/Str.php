<?php

namespace Memuya\Fab\Utilities;

class Str
{
    /**
     * Convert the given string to PascalCase.
     *
     * @param string $string
     * @return string
     */
    public static function toPascalCase(string $string): string
    {
        return self::removeWhiteSpace(
            ucwords(self::replace($string, ['_', '-'], ' ')),
        );
    }

    /**
     * Convert the given string to camelCase.
     *
     * @param string $string
     * @return string
     */
    public static function toCamelCase(string $string): string
    {
        return lcfirst(self::toPascalCase($string));
    }

    /**
     * Remove white space from the given string.
     *
     * @param string $string
     * @return string
     */
    public static function removeWhiteSpace(string $string): string
    {
        return self::replace($string, ' ', '');
    }

    /**
     * Replace characters with another in the given string.
     *
     * @param string $string
     * @param string|array $search
     * @param string $replace
     * @return string
     */
    public static function replace(string $string, string|array $search, string $replace): string
    {
        return str_replace($search, $replace, $string);
    }
}
