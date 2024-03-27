<?php

namespace Memuya\Fab\Utilities\Extract;

use UnitEnum;
use Exception;
use BackedEnum;
use Stringable;
use ReflectionClass;
use Memuya\Fab\Utilities\Extract\Type\Type;
use Memuya\Fab\Utilities\Extract\Type\TypeUnitEnum;
use Memuya\Fab\Utilities\Extract\Type\TypeBackedEnum;
use Memuya\Fab\Utilities\Extract\Type\TypeStringable;

class Value
{
    /**
     * The supported instance types that a value can be extracted from
     * and their corresponding 'extractor' class.
     *
     * @return array
     */
    private static $supportedTypes = [
        BackedEnum::class => TypeBackedEnum::class,
        UnitEnum::class => TypeUnitEnum::class,
        Stringable::class => TypeStringable::class,
    ];

    /**
     * The 'value' that we need to try and extract from.
     *
     * @var mixed
     */
    private mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * Create a new instance.
     *
     * @param mixed $value
     * @return self
     */
    public static function from(mixed $value): self
    {
        return new self($value);
    }

    /**
     * Extract the value depeneding on its instance type.
     *
     * @return mixed
     */
    public function extract(): mixed
    {
        foreach (self::$supportedTypes as $type => $extractor) {
            if (! $this->value instanceof $type) {
                continue;
            }

            $reflection = new ReflectionClass($extractor);

            if (! $reflection->implementsInterface(Type::class)) {
                throw new Exception(sprintf('"%s" does not implement interface "%s"', $extractor, Type::class));
            }

            return $reflection
                ->newInstance($this->value)
                ->extract();
        }

        return $this->value;
    }
}
