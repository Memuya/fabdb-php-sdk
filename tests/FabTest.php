<?php

use Memuya\Fab\Fab;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\RequestConfig\CardsConfig;
use Memuya\Fab\Exceptions\ResponseFormatNotSupportedException;

final class FabTest extends TestCase
{
    private $fab;
    private $configData;

    public function setUp(): void
    {
        $this->fab = new Fab;

        // This array follows the same order as the public properties in CardsConfig.
        $this->configData = [
            'page' => 1,
            'keywords' => 'search terms',
            'per_page' => 10,
            'pitch' => '3',
            'class' => 'brute',
            'cost' => '1',
            'rarity' => 'C',
            'set' => 'WTR',
        ];
    }

    public function testCanChangeResponseFormat()
    {
        $this->fab->setResponseFormat(Fab::RESPONSE_FORMAT_XML);

        $this->assertSame(Fab::RESPONSE_FORMAT_XML, $this->fab->getResponseFormat());
    }

    public function testResponseFormatIsValidated()
    {
        $this->expectException(ResponseFormatNotSupportedException::class);
        
        $this->fab->setResponseFormat('invalid');
    }

    public function testCanGetCardsWithDefaultConfig(): void
    {
        $cards = $this->fab->cards(
            new CardsConfig()
        );

        $this->assertInstanceOf(stdClass::class, $cards);
    }

    public function testCanGetCardsWithValidConfig(): void
    {
        $cards = $this->fab->cards(
            new CardsConfig($this->configData)
        );

        $this->assertInstanceOf(stdClass::class, $cards);
    }
}