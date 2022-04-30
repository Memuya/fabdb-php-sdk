<?php

namespace Memuya\Fab\Endpoints\Deck;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Endpoints\BaseConfig;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

class DeckConfig extends BaseConfig
{
   public string $slug;
}