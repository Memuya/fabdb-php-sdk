<?php

namespace Memuya\Fab\Clients\File\Endpoints\Cards;

use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use Memuya\Fab\Attributes\QueryString;
use Memuya\Fab\Endpoints\BaseConfig;

class CardsConfig extends BaseConfig
{
    /**
     * Name to search with.
     *
     * @var string
     */
    #[QueryString]
    public string $name;

    /**
     * The pitch count to filter by.
     *
     * @var Pitch
     */
    #[QueryString]
    public Pitch $pitch;

    /**
     * The class to filter by.
     *
     * @var HeroClass
     */
    #[QueryString]
    public HeroClass $class;

    /**
     * The cost to filter by.
     *
     * @var string
     */
    #[QueryString]
    public string $cost;

    /**
     * The rarity to filter by.
     *
     * @var Rarity
     */
    #[QueryString]
    public Rarity $rarity;

    /**
     * The set to filter by.
     *
     * @var Set
     */
    #[QueryString]
    public Set $set;
}
