<?php

namespace Memuya\Fab\Clients\TheFabCube\Entities;

class Card extends Entity
{
    public string $uniqueId;
    public string $name;
    public string $pitch;
    public string $cost;
    public ?string $power;
    public string $defense;
    public ?string $health;
    public ?string $intelligence;
    public ?string $arcane;
    public array $types = [];
    public array $cardKeywords = [];
    public array $abilitiesAndEffects = [];
    public array $abilityAndEffectKeywords = [];
    public array $grantedKeywords = [];
    public array $removedKeywords = [];
    public array $interactsWithKeywords = [];
    public string $functionalText;
    public string $functionalTextPlain;
    public string $typeText;
    public bool $playedHorizontally;
    public bool $blitzLegal;
    public bool $ccLegal;
    public bool $commonerLegal;
    public bool $llLegal;
    public bool $blitzLivingLegend;
    public bool $ccLivingLegend;
    public bool $blitzBanned;
    public bool $ccBanned;
    public bool $commonerBanned;
    public bool $llBanned;
    public bool $upfBanned;
    public bool $blitzSuspended;
    public bool $ccSuspended;
    public bool $commonerSuspended;
    public bool $llRestricted;
    public array $printings = [];

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function setPrintings(array $printings)
    {
        $this->printings = array_map(fn($printing) => new Printing($printing), $printings);
    }
}
