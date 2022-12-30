<?php

namespace Memuya\Fab\Endpoints;

use UnitEnum;
use BackedEnum;
use Stringable;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Utilities\Str;
use Memuya\Fab\Attributes\QueryString;
use Memuya\Fab\Attributes\RequestBody;
use Memuya\Fab\Exceptions\PropertyNotSetException;

abstract class Config
{
    /**
     * The UNIX timestamp to be sent with all requests.
     *
     * @var int
     */
    #[QueryString]
    public int $time;

    /**
     * Set up all the properties on the child class with the data provided.
     * 
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setConfigFromArray($config);
        $this->time = time();
    }

    /**
     * Set up the config class proerties from the given array.
     *
     * @param array $config
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
     * @return array
     */
    public function getQueryStringValues(): array
    {
        return $this->getValuesFor(QueryString::class);
    }

    /**
     * Return the options that will be a part of the request body as an array.
     *
     * @return array
     */
    public function getRequestBodyValues(): array
    {
        return $this->getValuesFor(RequestBody::class);
    }

    /**
     * Return the values associated to the attribute passed in.
     *
     * @param string $attribute
     * @return array
     */
    private function getValuesFor(string $attribute): array
    {
        $reflection = new ReflectionClass($this);
        $data = [];

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $property_name = $property->getName();

            if (count($property->getAttributes($attribute)) === 0) {
                continue;
            }
                        
            try {
                $data[$property_name] = $this->extractValueFromProperty($property_name);
            } catch (PropertyNotSetException) {
                continue;
            }
        }

        return $data;
    }

    /**
     * Extract the value from the given property name. Especially useful for enums.
     *
     * @throws PropertyNotSetException
     * @param string $property_name
     * @return mixed
     */
    private function extractValueFromProperty(string $property_name): mixed
    {
        if (! isset($this->{$property_name})) {
            throw new PropertyNotSetException(sprintf('Property "%s" not set.', $property_name));
        }

        $value = $this->{$property_name};

        if ($value instanceof BackedEnum) {
            return $value->value;
        }
        
        if ($value instanceof UnitEnum) {
            return $value->name;
        }

        if ($value instanceof Stringable) {
            return (string) $value;
        }

        return $value;
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
}
