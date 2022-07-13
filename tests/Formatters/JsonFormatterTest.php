<?php

use Memuya\Fab\Formatters\JsonFormatter;
use PHPUnit\Framework\TestCase;

final class JsonFormatterTest extends TestCase
{
    public function testContentTypeIsApplicationJson()
    {
        $formatter = new JsonFormatter;

        $this->assertSame('application/json', $formatter->getContentType());
    }

    public function testCanFormatStringToJsonArray()
    {
        $formatter = new JsonFormatter;
        $json = $formatter->format('{"key": "value"}');

        $this->assertInstanceOf(stdClass::class, $json);
        $this->assertObjectHasAttribute('key', $json);
        $this->assertSame('value', $json->key);
    }
}