<?php

namespace Memuya\Fab\Clients\TheFabCube;

use Memuya\Fab\Clients\Client;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Clients\TheFabCube\Entities\Card;
use Memuya\Fab\Clients\TheFabCube\Filters\CostFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\NameFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\TypeFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PitchFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PowerFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\ArcaneFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\HealthFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\DefenceFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\UniqueIdFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\SetNumberFilter;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\TheFabCube\Filters\CardKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\IntelligenceFilter;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\TheFabCube\Filters\FunctionalTextFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\GrantedKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\RemovedKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\AbilitiesAndEffectsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\FunctionalTextPlainFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\InteractsWithKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\AbilitiesAndEffectsKeywordsFilter;

/**
 * The FAB Cube is a Git repo that store an up-to-date list of all Flesh and Blood cards.
 * This client is intended to be used with the JSON file located in this repo.
 *
 * @link https://github.com/the-fab-cube/flesh-and-blood-cards
 * @link https://raw.githubusercontent.com/the-fab-cube/flesh-and-blood-cards/refs/heads/develop/json/english/card.json
 */
class TheFabCubeClient implements Client
{
    private FileClient $fileClient;

    /**
     * @param string $filepath
     * @param array<Filterable> $filters
     */
    public function __construct(string $filepath, array $filters = [])
    {
        $this->fileClient = new FileClient(
            $filepath,
            $filters ?: $this->getDefaultFilters(),
        );
        $this->fileClient->registerConfig(ConfigType::MultiCard, CardsConfig::class);
        $this->fileClient->registerConfig(ConfigType::SingleCard, CardConfig::class);
    }

    /**
     * @inheritDoc
     * @return array<Card>
     */
    public function getCards(array $filters = []): array
    {
        $cards = $this->fileClient->getCards($filters);

        return array_map(fn(array $card): Card => new Card($card), $cards);
    }

    /**
     * @inheritDoc
     * @return Card|null
     */
    public function getCard(string $identifier, string $key = 'name'): ?Card
    {
        $card = $this->fileClient->getCard($identifier, $key);

        if (empty($card)) {
            return null;
        }

        return new Card($card);
    }

    /**
     * @inheritDoc
     */
    public function getDeck(string $slug): array
    {
        return [];
    }

    /**
     * Register filters can are usable when querying from the file.
     *
     * @param array<Filterable> $filters
     * @return void
     */
    public function registerFilters(array $filters): void
    {
        $this->getFileClient()->registerFilters($filters);
    }

    /**
     * Return the underlaying FileClient object.
     *
     * @return FileClient
     */
    public function getFileClient(): FileClient
    {
        return $this->fileClient;
    }

    /**
     * Return a list of filters to be registered if none are provided.
     *
     * @return array<Filterable>
     */
    private function getDefaultFilters(): array
    {
        return [
            new AbilitiesAndEffectsFilter(),
            new AbilitiesAndEffectsKeywordsFilter(),
            new ArcaneFilter(),
            new CardKeywordsFilter(),
            new CostFilter(),
            new DefenceFilter(),
            new FunctionalTextFilter(),
            new FunctionalTextPlainFilter(),
            new GrantedKeywordsFilter(),
            new HealthFilter(),
            new IntelligenceFilter(),
            new InteractsWithKeywordsFilter(),
            new NameFilter(),
            new PitchFilter(),
            new PowerFilter(),
            new RemovedKeywordsFilter(),
            new SetNumberFilter(),
            new TypeFilter(),
            new UniqueIdFilter(),
        ];
    }
}
