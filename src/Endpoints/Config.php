<?php

namespace Memuya\Fab\Endpoints;

use Exception;
use BackedEnum;
use ReflectionClass;
use ReflectionProperty;
use Memuya\Fab\Utilities\Str;
use Memuya\Fab\Attributes\QueryString;
use Memuya\Fab\Attributes\RequestBody;

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
            if (property_exists($this, $property)) {
                $method = sprintf('set%s', Str::toPascalCase($property));

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

            if (! isset($this->{$property_name})) {
                continue;
            }
            
            $value = $this->{$property_name} instanceof BackedEnum
                ? $this->{$property_name}->value 
                : $this->{$property_name}->name;

            $data[$property_name] = $value;
        }

        return $data;
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
}
