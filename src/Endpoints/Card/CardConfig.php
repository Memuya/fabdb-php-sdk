<?php

namespace Memuya\Fab\Endpoints\Card;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Endpoints\BaseConfig;
use Memuya\Fab\Exceptions\InvalidCardConfigException;

class CardConfig extends BaseConfig
{
   public string $identifier;
}