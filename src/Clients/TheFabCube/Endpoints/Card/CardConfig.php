<?php

namespace Memuya\Fab\Clients\TheFabCube\Endpoints\Card;

use Memuya\Fab\Clients\Config;
use Memuya\Fab\Attributes\Parameter;

class CardConfig extends Config
{
    /**
     * Name to search with.
     *
     * @var string
     */
    #[Parameter]
    public string $name;
}
