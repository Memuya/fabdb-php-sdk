<?php

namespace Memuya\Fab\Clients\File\Endpoints\Cards;

use Memuya\Fab\Enums\Set;
use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Enums\Rarity;
use Memuya\Fab\Enums\HeroClass;
use Memuya\Fab\Attributes\Parameter;
use Memuya\Fab\Clients\Config;

class CardsConfig extends Config
{
    /**
     * Name to search with.
     *
     * @var string
     */
    #[Parameter]
    public string $name;

    /**
     * The pitch count to filter by.
     *
     * @var Pitch
     */
    #[Parameter]
    public Pitch $pitch;

    /**
     * The class to filter by.
     *
     * @var HeroClass
     */
    #[Parameter]
    public HeroClass $class;

    /**
     * The cost to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $cost;

    /**
     * The rarity to filter by.
     *
     * @var Rarity
     */
    #[Parameter]
    public Rarity $rarity;

    /**
     * The set to filter by.
     *
     * @var Set
     */
    #[Parameter]
    public Set $set;
}
