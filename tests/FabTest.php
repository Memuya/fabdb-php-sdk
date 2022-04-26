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

    public function testCanChangeAndReturnResponseFormat()
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
        $this->assertObjectHasAttribute('data', $cards);
    }

    public function testCanGetCardsWithValidConfig(): void
    {
        $cards = $this->fab->cards(
            new CardsConfig($this->configData)
        );

        $this->assertInstanceOf(stdClass::class, $cards);
        $this->assertObjectHasAttribute('data', $cards);
    }

    public function testCanGetCardFromSlug(): void
    {
        $identifier = 'eye-of-ophidia';
        $card = $this->fab->card($identifier);

        $this->assertInstanceOf(stdClass::class, $card);
        $this->assertObjectHasAttribute('identifier', $card);
        $this->assertSame($identifier, $card->identifier);
    }

    public function testCanGetDeckFromSlug(): void
    {
        $slug = 'lDDjYZbe';
        $deck = $this->fab->deck($slug);

        // var_dump($deck); die;

        $this->assertInstanceOf(stdClass::class, $deck);
        $this->assertObjectHasAttribute('slug', $deck);
        $this->assertSame($slug, $deck->slug);
    }
}