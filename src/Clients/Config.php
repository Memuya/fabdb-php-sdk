<?php

namespace Memuya\Fab\Clients;

use Memuya\Fab\Attributes\Parameter;
use UnitEnum;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Attributes\QueryString;
use Memuya\Fab\Exceptions\PropertyNotSetException;
use Memuya\Fab\Utilities\Str;

abstract class Config
{
    /**
     * Set up all the properties on the child class with the data provided.
     *
     * @param array<string, mixed> $config
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
            $this->setProperty($property, $value);
        }
    }

    /**
     * Return the options that will be a part of the query string as an array.
     *
     * @return array<string, mixed>
     */
    public function getQueryStringValues(): array
    {
        return $this->getValuesFor(QueryString::class);
    }

    /**
     * Return the options that are marked as a parameter.
     *
     * @return array<string, mixed>
     */
    public function getParameterValues(): array
    {
        return $this->getValuesFor(Parameter::class);
    }

    /**
     * Return the values associated to the attribute passed in.
     *
     * @param class-string $attribute
     * @return array<string, mixed>
     */
    public function getValuesFor(string $attribute): array
    {
        $reflection = new ReflectionClass($this);
        $data = [];

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $property_name = $property->getName();

            if (count($property->getAttributes($attribute)) === 0) {
                continue;
            }

            if (! isset($this->{$property_name})) {
                continue;
            }

            try {
                // If we have an enum we want to extract the value from it.
                $value = $this->{$property_name} instanceof UnitEnum
                    ? $this->{$property_name}->value
                    : $this->{$property_name};

                $data[$property_name] = $value;
            } catch (PropertyNotSetException) {
                continue;
            }
        }

        return $data;
    }

    /**
     * Set a property's value, using a setter method if found.
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    private function setProperty(string $property, mixed $value): void
    {
        if (! property_exists($this, $property)) {
            return;
        }

        $method = sprintf('set%s', Str::toPascalCase($property));

        if (method_exists($this, $method)) {
            $this->{$method}($value);

            return;
        }

        $this->{$property} = $value;
    }

    public function __toString()
    {
        return $this->getQueryStringValues();
    }
}
