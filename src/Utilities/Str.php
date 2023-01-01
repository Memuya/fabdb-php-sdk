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
        return str_replace(' ', '', ucwords(str_replace(['_', '-'], ' ', $string)));
    }
}
