<?php

use Memuya\Fab\Enums\Pitch;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Clients\File\Filters\CostFilter;
use Memuya\Fab\Clients\File\Filters\NameFilter;
use Memuya\Fab\Clients\File\Filters\PitchFilter;
use Memuya\Fab\Clients\File\Filters\SetNumberFilter;

final class FileClientTest extends TestCase
{
    private FileClient $client;

    public function setUp(): void
    {
        $this->client = new FileClient(
            filepath: '/app/cards.json',
            filters: [
                new NameFilter(),
                new PitchFilter(),
                new CostFilter(),
                new SetNumberFilter(),
            ]
        );
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
        $card = $this->client->getCard('Luminaris');

        $this->assertIsArray($card);
        $this->assertSame('Luminaris', $card['name']);
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

    public function testCanRegisterConfigDirectlyToFilterListWithCustomFilter(): void
    {
        $client = new FileClient('/app/tests/test_cards.json');
        $client->registerFilters([new IdentifierFilter()]);

        $cards = $client->filterList(
            new TestConfig(['identifier' => 'first'])
        );

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterDifferentConfigForCardsEndpoint(): void
    {
        $client = new FileClient('/app/tests/test_cards.json');
        $client->registerFilters([new IdentifierFilter()]);
        $client->registerConfig(ConfigType::Cards, TestConfig::class);

        $cards = $client->getCards(['identifier' => 'first']);

        $this->assertIsArray($cards);
        $this->assertCount(1, $cards);
    }

    public function testCanRegisterDifferentConfigForCardEndpoint(): void
    {
        $client = new FileClient('/app/tests/test_cards.json');
        $client->registerFilters([new IdentifierFilter()]);
        $client->registerConfig(ConfigType::Card, TestConfig::class);

        $cards = $client->getCard('first');

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
