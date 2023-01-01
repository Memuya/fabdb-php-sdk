<?php

namespace Memuya\Fab\Utilities\Extract\Type;

interface Type
{
    /**
     * Extract the value from a property.
     *
     * @return mixed
     */
    public function extract(): mixed;
}