<?php

namespace Memuya\Fab\Clients;

use Memuya\Fab\Attributes\Parameter;
use UnitEnum;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Attributes\QueryString;

class BaseConfig
{
    /**
     * Set up all the properties on the child class with the data provided.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setConfigFromArray($config);
    }

    /**
     * Set up the config class proerties from the given array.
     *
     * @param array<string, mixed> $config
     * @return void
     */
    public function setConfigFromArray(array $config): void
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
     * Convert the config into an array.
     *
     * @param class-string $type
     * @return array<string, mixed>
     */
    public function toArray(string $type = null): array
    {
        $reflection = new ReflectionClass($this);
        $data = [];

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $property_name = $property->getName();

            if (
                $type &&
                count($property->getAttributes($type)) === 0
            ) {
                continue;
            }

            if (! isset($this->{$property_name})) {
                continue;
            }

            // If we have an enum we want to extract the value from it.
            $value = $this->{$property_name} instanceof UnitEnum
                ? $this->{$property_name}->value
                : $this->{$property_name};

            $data[$property_name] = $value;
        }

        return $data;
    }

    /**
     * Convert the config into a usable query string.
     *
     * @return string
     */
    public function toQueryString(): string
    {
        return http_build_query($this->toArray(QueryString::class));
    }

    /**
     * Convert the config into an array of only the properties marked as a 'Parameter'.
     *
     * @return array<string, mixed>
     */
    public function onlyParameters(): array
    {
        return $this->toArray(Parameter::class);
    }

    public function __toString()
    {
        return $this->toQueryString();
    }
}