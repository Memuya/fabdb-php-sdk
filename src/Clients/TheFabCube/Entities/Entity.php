<?php

namespace Memuya\Fab\Clients\TheFabCube\Entities;

use Memuya\Fab\Utilities\Str;

abstract class Entity
{
    public function __construct(array $data)
    {
        $this->setProperties($data);
    }

    /**
     * Set multiple properties.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    protected function setProperties(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->setProperty($key, $value);
        }
    }

    /**
     * Set a property, trying to use an associated setter if present.
     *
     * @param string $propertyName
     * @param mixed $value
     * @return void
     */
    protected function setProperty(string $propertyName, mixed $value): void
    {
        $property = Str::toCamelCase($propertyName);

        if (property_exists($this, $property)) {
            $method = sprintf('set%s', Str::toPascalCase($propertyName));

            if (method_exists($this, $method)) {
                $this->{$method}($value);

                return;
            }

            $this->{$property} = $value;
        }
    }
}
