<?php

use Memuya\Fab\Client;
use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Card\CardConfig;
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsEndpoint;
use Memuya\Fab\Exceptions\ResponseFormatNotSupportedException;

final class ClientTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client;
    }

    public function testCanChangeAndReturnResponseFormat()
    {
        $this->client->setResponseFormat(Client::RESPONSE_FORMAT_XML);

        $this->assertSame(Client::RESPONSE_FORMAT_XML, $this->client->getResponseFormat());
    }

    public function testResponseFormatIsValidated()
    {
        $this->expectException(ResponseFormatNotSupportedException::class);
        
        $this->client->setResponseFormat('invalid');
    }

    public function testCanGetCardsWithDefaultConfig(): void
    {
        $cards = $this->client->sendRequest(
            new CardsEndpoint(new CardsConfig())
        );

        $this->assertInstanceOf(stdClass::class, $cards);
        $this->assertObjectHasAttribute('data', $cards);
    }

    public function testCanGetCardsWithValidConfig(): void
    {
        $data = [
            'page' => 1,
            'keywords' => 'search terms',
            'per_page' => 1,
            'cost' => '1',
            'pitch' => Pitch::One,
            'class' => HeroClass::Brute,
            'rarity' => Rarity::Rare,
            'set' => Set::ArcaneRising,
        ];

        $cards = $this->client->sendRequest(
            new CardsEndpoint(
                new CardsConfig($data)
            )
        );

        // var_dump($cards->data[0]); die;

        $this->assertInstanceOf(stdClass::class, $cards);
        $this->assertObjectHasAttribute('data', $cards);
    }

    public function testCanGetCardFromIdentifier(): void
    {
        $identifier = 'eye-of-ophidia';
        $card = $this->client->sendRequest(
            new CardEndpoint(
                new CardConfig([
                    'identifier' => $identifier,
                ])
            )
        );

        $this->assertInstanceOf(stdClass::class, $card);
        $this->assertObjectHasAttribute('identifier', $card);
        $this->assertSame($identifier, $card->identifier);
    }

    public function testCanGetDeckFromSlug(): void
    {
        $slug = 'lDDjYZbe';
        $deck = $this->client->sendRequest(
            new DeckEndpoint(
                new DeckConfig([
                    'slug' => $slug,
                ])
            )
        );

        $this->assertInstanceOf(stdClass::class, $deck);
        $this->assertObjectHasAttribute('slug', $deck);
        $this->assertSame($slug, $deck->slug);
    }
}