<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Enums\HttpContentType;
use Memuya\Fab\Formatters\JsonFormatter;

final class JsonFormatterTest extends TestCase
{
    public function testContentTypeIsApplicationJson()
    {
        $formatter = new JsonFormatter();

        $this->assertSame(HttpContentType::JSON, $formatter->getContentType());
    }

    public function testCanFormatStringToJsonArray()
    {
        $formatter = new JsonFormatter();
        $json = $formatter->format('{"key": "value"}');

        $this->assertInstanceOf(stdClass::class, $json);
        $this->assertObjectHasAttribute('key', $json);
        $this->assertSame('value', $json->key);
    }
}
