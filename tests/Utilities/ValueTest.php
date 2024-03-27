<?php

use Memuya\Fab\Enums\HeroClass;
use PHPUnit\Framework\TestCase;
use Memuya\Fab\Utilities\Extract\Value;

final class ValueTest extends TestCase
{
    /** @test */
    public function testCanExtractValueFromBackedEnum()
    {
        $this->assertSame(
            HeroClass::Illusionist->value,
            Value::from(HeroClass::Illusionist)->extract()
        );
    }

    /** @test */
    public function testCanExtractValueFromUnitEnum()
    {
        $this->assertSame(
            TestUnitEnum::ACase->name,
            Value::from(TestUnitEnum::ACase)->extract()
        );
    }

    /** @test */
    public function testCanExtractValueFromStringable()
    {
        $stringable_object = new class implements \Stringable
        {
            public function __toString()
            {
                return 'test';
            }
        };

        $this->assertSame(
            'test',
            Value::from($stringable_object)->extract()
        );
    }
}

enum TestUnitEnum {
    case ACase;
}
