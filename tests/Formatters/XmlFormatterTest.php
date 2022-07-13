<?php

use PHPUnit\Framework\TestCase;
use Memuya\Fab\Formatters\XmlFormatter;

final class XmlFormatterTest extends TestCase
{
    public function testContentTypeIsApplicationJson()
    {
        $formatter = new XmlFormatter;

        $this->assertSame('application/xml', $formatter->getContentType());
    }

    public function testCanFormatStringToSimpleXMLElement()
    {
        $formatter = new XmlFormatter;

        $this->assertInstanceOf(
            SimpleXMLElement::class,
            $formatter->format("<?xml version='1.0' encoding='UTF-8'?><note><from>Bob</from><to>Jane</to><message>This is a test</message></note>")
        );
    }
}