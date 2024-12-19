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
    /** @var array<string> */
    public array $types = [];
    /** @var array<string> */
    public array $cardKeywords = [];
    /** @var array<string> */
    public array $abilitiesAndEffects = [];
    /** @var array<string> */
    public array $abilityAndEffectKeywords = [];
    /** @var array<string> */
    public array $grantedKeywords = [];
    /** @var array<string> */
    public array $removedKeywords = [];
    /** @var array<string> */
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
    /** @var array<Printing> */
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
