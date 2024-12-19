<?php

namespace Memuya\Fab\Clients\TheFabCube;

use Memuya\Fab\Clients\Client;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Clients\TheFabCube\Entities\Card;
use Memuya\Fab\Clients\TheFabCube\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Cards\CardsConfig;

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

        return array_map(
            fn(array $card): Card => new Card($card),
            $cards,
        );
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
            new \Memuya\Fab\Clients\TheFabCube\Filters\AbilitiesAndEffectsFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\AbilitiesAndEffectsKeywordsFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\ArcaneFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\BlitzBannedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\BlitzLegalFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\BlitzLivingLegendFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\BlitzSuspendedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CardIdFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CardKeywordsFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CcBannedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CcLegalFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CcLivingLegendFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CcSuspendedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CommonerBannedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CommonerLegalFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CommonerSuspendedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\CostFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\DefenseFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\FunctionalTextFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\FunctionalTextPlainFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\GrantedKeywordsFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\HealthFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\IntelligenceFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\InteractsWithKeywordsFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\LlBannedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\LlLegal(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\LlRestrictedFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\NameFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\PitchFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\PlayedHorizontallyFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\PowerFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\RarityFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\RemovedKeywordsFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\SetFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\TypeFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\TypeTextFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\UniqueIdFilter(),
            new \Memuya\Fab\Clients\TheFabCube\Filters\UpfBannedFilter(),
        ];
    }
}
