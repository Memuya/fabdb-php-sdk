<?php

namespace Memuya\Fab\Clients\TheFabCube\Endpoints\Cards;

use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Clients\Config;
use Memuya\Fab\Attributes\Parameter;

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
     * The cost to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $cost;

    /**
     * The card ID to filter by. For example, HVY163.
     *
     * @var string
     */
    #[Parameter]
    public string $set_id;

    /**
     * The attack power to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $power;

    /**
     * The types to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $type;
}