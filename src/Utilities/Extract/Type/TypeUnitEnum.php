<?php

namespace Memuya\Fab\Utilities\Extract\Type;

use UnitEnum;

class TypeUnitEnum implements Type
{
    private UnitEnum $enum;
    
    public function __construct(UnitEnum $enum)
    {
        $this->enum = $enum;
    }

    public function extract(): mixed
    {
        return $this->enum->name;
    }
}