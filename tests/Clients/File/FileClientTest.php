<?php

use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Clients\File\FileClient;

final class FileClientTest extends TestCase
{
    private FileClient $client;

    public function setUp(): void
    {
        $this->client = new FileClient('/app/cards.json');
    }

    public function testCanReadFromJsonFile(): void
    {
        $cards = $this->client->getCards();

        $this->assertNotEmpty($cards);
    }

    public function testCanFilterResults(): void
    {
        $cards = $this->client->getCards([
            'name' => '10,000 Year Reunion',
            'pitch' => Pitch::One,
        ]);

        $this->assertNotEmpty($cards);
        $this->assertCount(1, $cards);
        $this->assertSame('10,000 Year Reunion', $cards[0]['name']);
    }

    public function testResultIsEmptyWhenFiltersDoNotMatchACard(): void
    {
        $cards = $this->client->getCards([
            'name' => '10,000 Year Reunion',
            'pitch' => Pitch::Two,
        ]);

        $this->assertEmpty($cards);
    }

    public function testCanReturnASingleCard(): void
    {
        $card = $this->client->getCard('10,000 Year Reunion');

        $this->assertIsArray($card);
        $this->assertSame('10,000 Year Reunion', $card['name']);
    }

    public function testCanFilterFileWithCustomFilterAndConfigViaConstructor(): void
    {
        $client = new FileClient(
            filepath: '/app/tests/test_cards.json',
            filters: [new IdentifierFilter()],
        );

        $cards = $client->filterList(
            new TestConfig(['identifier' => 'first'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanFilterFileWithCustomFilterAndConfigViaRegisterMethod(): void
    {
        $client = new FileClient('/app/tests/test_cards.json');
        $client->registerFilters([new IdentifierFilter()]);

        $cards = $client->filterList(
            new TestConfig(['identifier' => 'first'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }
}

class TestConfig extends \Memuya\Fab\Clients\Config
{
    #[\Memuya\Fab\Attributes\Parameter]
    public string $identifier;
}

class IdentifierFilter implements \Memuya\Fab\Clients\File\Filters\Filterable
{
    /**
     * @inheritDoc
     */
    public function canResolve(array $filters): bool
    {
        return isset($filters['identifier']) && ! is_null($filters['identifier']);
    }

    /**
     * @inheritDoc
     */
    public function applyTo(array $data, array $filters): array
    {
        return array_filter($data, function ($card) use ($filters) {
            return str_contains($card['identifier'], $filters['identifier']);
        });
    }
}
