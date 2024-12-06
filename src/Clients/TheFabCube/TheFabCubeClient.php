<?php

namespace Memuya\Fab\Clients\TheFabCube;

use Memuya\Fab\Clients\Client;
use Memuya\Fab\Clients\File\ConfigType;
use Memuya\Fab\Clients\File\FileClient;
use Memuya\Fab\Clients\TheFabCube\Entities\Card;
use Memuya\Fab\Clients\TheFabCube\Filters\LlLegal;
use Memuya\Fab\Clients\TheFabCube\Filters\CostFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\Filterable;
use Memuya\Fab\Clients\TheFabCube\Filters\NameFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\TypeFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PitchFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PowerFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\ArcaneFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CardIdFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\HealthFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CcLegalFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\DefenseFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CcBannedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\LlBannedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\TypeTextFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\UniqueIdFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\UpfBannedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\BlitzLegalFilter;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Card\CardConfig;
use Memuya\Fab\Clients\TheFabCube\Filters\BlitzBannedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CcSuspendedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CardKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\IntelligenceFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\LlRestrictedFilter;
use Memuya\Fab\Clients\TheFabCube\Endpoints\Cards\CardsConfig;
use Memuya\Fab\Clients\TheFabCube\Filters\CommonerLegalFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\BlitzSuspendedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CcLivingLegendFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CommonerBannedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\FunctionalTextFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\GrantedKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\RemovedKeywordsFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\BlitzLivingLegendFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\CommonerSuspendedFilter;
use Memuya\Fab\Clients\TheFabCube\Filters\PlayedHorizontallyFilter;
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
            new BlitzBannedFilter(),
            new BlitzLegalFilter(),
            new BlitzLivingLegendFilter(),
            new BlitzSuspendedFilter(),
            new CardIdFilter(),
            new CardKeywordsFilter(),
            new CcBannedFilter(),
            new CcLegalFilter(),
            new CcLivingLegendFilter(),
            new CcSuspendedFilter(),
            new CommonerBannedFilter(),
            new CommonerLegalFilter(),
            new CommonerSuspendedFilter(),
            new CostFilter(),
            new DefenseFilter(),
            new FunctionalTextFilter(),
            new FunctionalTextPlainFilter(),
            new GrantedKeywordsFilter(),
            new HealthFilter(),
            new IntelligenceFilter(),
            new InteractsWithKeywordsFilter(),
            new LlBannedFilter(),
            new LlLegal(),
            new LlRestrictedFilter(),
            new NameFilter(),
            new PitchFilter(),
            new PlayedHorizontallyFilter(),
            new PowerFilter(),
            new RemovedKeywordsFilter(),
            new TypeFilter(),
            new TypeTextFilter(),
            new UniqueIdFilter(),
            new UpfBannedFilter(),
        ];
    }
}
