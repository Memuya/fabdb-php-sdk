<?php

namespace Memuya\Fab\Utilities\Extract\Type;

use Stringable;

class TypeStringable implements Type
{
    private Stringable $stringable;
    
    public function __construct(Stringable $stringable)
    {
        $this->stringable = $stringable;
    }

    public function extract(): string
    {
        return (string) $this->stringable;
    }
}