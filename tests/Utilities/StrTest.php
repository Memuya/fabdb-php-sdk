<?php

use Memuya\Fab\Utilities\Str;
use PHPUnit\Framework\TestCase;

final class StrTest extends TestCase
{
    public function setUp(): void {}

    public function testToPascalCase()
    {
        $snake_case = 'a_test_string';
        $dashes = 'a-test-string';
        $camel_case = 'aTestString';
        $expected = 'ATestString';

        $this->assertSame($expected, Str::toPascalCase($snake_case));
        $this->assertSame($expected, Str::toPascalCase($dashes));
        $this->assertSame($expected, Str::toPascalCase($camel_case));
    }

    public function testToCamelCase()
    {
        $snake_case = 'a_test_string';
        $dashes = 'a-test-string';
        $pascal_case = 'ATestString';
        $expected = 'aTestString';

        $this->assertSame($expected, Str::toCamelCase($snake_case));
        $this->assertSame($expected, Str::toCamelCase($dashes));
        $this->assertSame($expected, Str::toCamelCase($pascal_case));
    }

    public function testRemoveWhiteSpace()
    {
        $original_string = 'hello world';
        $expected = 'helloworld';

        $this->assertSame($expected, Str::removeWhiteSpace($original_string));
    }

    public function testReplace()
    {
        $original_string = 'hello world';
        $expected = 'hello all';

        $this->assertSame($expected, Str::replace($original_string, 'world', 'all'));
    }
}
