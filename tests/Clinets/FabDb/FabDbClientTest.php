<?php

use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Card\CardEndpoint;
use Memuya\Fab\Clients\FabDb\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Cards\CardsEndpoint;
use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckConfig;
use Memuya\Fab\Clients\FabDb\Endpoints\Deck\DeckEndpoint;
use Memuya\Fab\Clients\FabDb\FabDbClient;
use Memuya\Fab\Clients\FabDb\Formatters\CsvFormatter;
use Memuya\Fab\Clients\FabDb\Formatters\JsonFormatter;
use Memuya\Fab\Clients\FabDb\Formatters\XmlFormatter;
use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use PHPUnit\Framework\TestCase;

final class FabDbClientTest extends TestCase
{
    private FabDbClient $client;

    public function setUp(): void
    {
        $this->client = new FabDbClient();
    }

    public function testCanReturnRawResponse()
    {
        $this->client->shouldReturnRaw();
        $cards = $this->client->sendRequest(new CardsEndpoint(new CardsConfig()));

        $this->assertIsString($cards);
    }

    public function testCanChangeResponseFormat()
    {
        $this->client->setFormatter(new CsvFormatter());
        $this->assertInstanceOf(CsvFormatter::class, $this->client->getFormatter());

        $this->client->setFormatter(new XmlFormatter());
        $this->assertInstanceOf(XmlFormatter::class, $this->client->getFormatter());

        $this->client->setFormatter(new JsonFormatter());
        $this->assertInstanceOf(JsonFormatter::class, $this->client->getFormatter());
    }

    public function testCanGetCardsWithDefaultConfig(): void
    {
        $cards = $this->client->sendRequest(new CardsEndpoint(new CardsConfig()));

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
