<?php

namespace Memuya\Fab\Clients\TheFabCube\Endpoints\Cards;

use Memuya\Fab\Enums\Pitch;
use Memuya\Fab\Clients\Config;
use Memuya\Fab\Attributes\Parameter;

class CardsConfig extends Config
{
    /**
     * The name to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $name;

    /**
     * The pitch to filter by.
     *
     * @var Pitch
     */
    #[Parameter]
    public Pitch $pitch;

    /**
     * The cost to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $cost;

    /**
     * The set ID to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $set_id;

    /**
     * The power to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $power;

    /**
     * The unique ID to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $unique_id;

    /**
     * The defense to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $defense;

    /**
     * The health to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $health;

    /**
     * The intelligence to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $intelligence;

    /**
     * The arcane to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $arcane;

    /**
     * The types to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $types;

    /**
     * The card keywords to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $card_keywords;

    /**
     * The abilities and effects to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $abilities_and_effects;

    /**
     * The ability and effect keywords to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $ability_and_effect_keywords;

    /**
     * The granted keywords to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $granted_keywords;

    /**
     * The removed keywords to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $removed_keywords;

    /**
     * The keywords the card interacts with to filter by.
     *
     * @var array<string>
     */
    #[Parameter]
    public array $interacts_with_keywords;

    /**
     * The functional text to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $functional_text;

    /**
     * The plain functional text to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $functional_text_plain;

    /**
     * The type text to filter by.
     *
     * @var string
     */
    #[Parameter]
    public string $type_text;

    /**
     * Whether the card is played horizontally to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $played_horizontally;

    /**
     * Whether the card is Blitz legal to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $blitz_legal;

    /**
     * Whether the card is CC legal to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $cc_legal;

    /**
     * Whether the card is Commoner legal to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $commoner_legal;

    /**
     * Whether the card is LL legal to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $ll_legal;

    /**
     * Whether the card is a Blitz Living Legend to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $blitz_living_legend;

    /**
     * Whether the card is a CC Living Legend to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $cc_living_legend;

    /**
     * Whether the card is banned in Blitz to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $blitz_banned;

    /**
     * Whether the card is banned in CC to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $cc_banned;

    /**
     * Whether the card is banned in Commoner to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $commoner_banned;

    /**
     * Whether the card is banned in LL to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $ll_banned;

    /**
     * Whether the card is banned in UPF to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $upf_banned;

    /**
     * Whether the card is suspended in Blitz to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $blitz_suspended;

    /**
     * Whether the card is suspended in CC to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $cc_suspended;

    /**
     * Whether the card is suspended in Commoner to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $commoner_suspended;

    /**
     * Whether the card is restricted in LL to filter by.
     *
     * @var bool
     */
    #[Parameter]
    public bool $ll_restricted;
}
