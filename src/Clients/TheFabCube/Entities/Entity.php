<?php

namespace Memuya\Fab\Clients\TheFabCube\Entities;

use Memuya\Fab\Utilities\Str;

abstract class Entity
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $property = Str::toCamelCase($key);
            
            if (property_exists($this, $property)) {
                $method = sprintf('set%s', Str::toPascalCase($key));

                if (method_exists($this, $method)) {
                    $this->{$method}($value);
                    continue;
                }

                $this->{$property} = $value;
            }
        }
    }
}
