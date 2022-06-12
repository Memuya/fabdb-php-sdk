<?php

namespace Memuya\Fab\Endpoints;

use UnitEnum;
use BackedEnum;
use ReflectionClass;

class BaseConfig
{
    /**
     * Set up all the properties on the child class with the data provided.
     * 
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $property => $value) {
            if (property_exists($this, $property)) {
                $camel_case_property = str_replace(' ', '', ucwords(str_replace('_', ' ', $property)));
                $method = sprintf('set%s', $camel_case_property);

                // If there's a setter for the given property, we'll use that instead.
                if (method_exists($this, $method)) {
                    $this->{$method}($value);

                    continue;
                }

                $this->{$property} = $value;
            }
        }
    }

    /**
     * Convert the config into a usable query string.
     *
     * @return string
     */
    public function toQueryString(): string
    {
        $reflection = new ReflectionClass($this);
        $query_string_array = [];

        foreach ($reflection->getProperties() as $property) {
            $property_name = $property->getName();

            if (! isset($this->{$property_name})) {
                continue;
            }

            // If we have an enum we want to extract the value from it.
            $value = $this->{$property_name} instanceof BackedEnum || $this->{$property_name} instanceof UnitEnum
                ? $this->{$property_name}->value 
                : $this->{$property_name};

            $query_string_array[$property_name] = $value;
        }

        return http_build_query($query_string_array);
    }
}
