<?php

use Memuya\Fab\Client;
use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\Talent;
use Memuya\Fab\Enums\HeroClass;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Endpoints\Card\CardConfig;
use Memuya\Fab\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Endpoints\Deck\DeckEndpoint;
use Memuya\Fab\Endpoints\Cards\CardsEndpoint;
use Memuya\Fab\Enums\CardType;
use Memuya\Fab\Formatters\CsvFormatter;
use Memuya\Fab\Formatters\JsonFormatter;
use Memuya\Fab\Formatters\XmlFormatter;

final class ClientTest extends TestCase
{
    private Client $client;
    private $clientStub;

    public function setUp(): void
    {
        $this->client = new Client('token', 'secret');
        $this->clientStub = $this->createStub(Client::class);
    }

    public function testCanReturnRawResponse()
    {
        // $this->clientStub->shouldReturnRaw();
        // $this->clientStub->method('sendRequest')->willReturn('{"name": "test"}');

        // $this->assertSame('test', $this->clientStub->sendRequest(new CardsEndpoint(new CardsConfig())));

        $this->client->shouldReturnRaw();
        $cards = $this->client->sendRequest(new CardsEndpoint(new CardsConfig()));

        $this->assertIsString($cards);
    }

    public function testCanChangeResponseFormat()
    {
        $this->client->setFormatter(new CsvFormatter);
        $this->assertInstanceOf(CsvFormatter::class, $this->client->getFormatter());

        $this->client->setFormatter(new XmlFormatter);
        $this->assertInstanceOf(XmlFormatter::class, $this->client->getFormatter());

        $this->client->setFormatter(new JsonFormatter);
        $this->assertInstanceOf(JsonFormatter::class, $this->client->getFormatter());
    }

    public function testCanGetCardsWithDefaultConfig(): void
    {
        $this->clientStub->method('sendRequest')->willReturn((object) ['data' => []]);
        $cards = $this->clientStub->sendRequest(new CardsEndpoint(new CardsConfig()));
        // $cards = $this->client->sendRequest(new CardsEndpoint(new CardsConfig()));

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
            'talent' => Talent::None,
            'cardType' => CardType::AttackReaction,
        ];

        $cards = $this->client->sendRequest(
            new CardsEndpoint(
                new CardsConfig($data)
            )
        );

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