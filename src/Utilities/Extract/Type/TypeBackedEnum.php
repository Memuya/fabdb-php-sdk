<?php

namespace Memuya\Fab\Utilities\Extract\Type;

use BackedEnum;

class TypeBackedEnum implements Type
{
    private BackedEnum $enum;
    
    public function __construct(BackedEnum $enum)
    {
        $this->enum = $enum;
    }

    public function extract(): mixed
    {
        return $this->enum->value;
    }
}