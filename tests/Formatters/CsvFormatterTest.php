<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Enums\HttpContentType;
use Memuya\Fab\Formatters\CsvFormatter;

final class CsvFormatterTest extends TestCase
{
    public function testContentTypeIsApplicationJson()
    {
        $formatter = new CsvFormatter();

        $this->assertSame(HttpContentType::CSV, $formatter->getContentType());
    }

    public function testCanFormatStringCsv()
    {
        $formatter = new CsvFormatter();

        $this->assertIsString($formatter->format('one,two,three'));
    }
}
