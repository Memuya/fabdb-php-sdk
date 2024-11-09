<?php

namespace Memuya\Fab\Clients\File\Endpoints\Card;

use Memuya\Fab\Attributes\Parameter;
use Memuya\Fab\Clients\Config;

class CardConfig extends Config
{
    #[Parameter]
    public string $name;
}
