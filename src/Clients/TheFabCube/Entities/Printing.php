<?php

namespace Memuya\Fab\Clients\TheFabCube\Entities;

class Printing extends Entity
{
    public string $uniqueId;
    public string $setPrintingUniqueId;
    public string $id;
    public string $setId;
    public string $edition;
    public string $foiling;
    public string $rarity;
    public bool $expansionSlot;
    public array $artists = [];
    public array $artVariations = [];
    public string $flavorText;
    public string $flavorTextPlain;
    public string $imageUrl;
    public int $imageRotationDegrees;
    public string $tcgplayerProductId;
    public string $tcgplayerUrl;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }
}
