<?php

namespace Memuya\Fab\Clients\File\Endpoints\Card;

use Memuya\Fab\Attributes\Parameter;
use Memuya\Fab\Clients\BaseConfig;

class CardConfig extends BaseConfig
{
    #[Parameter]
    public string $name;
}
