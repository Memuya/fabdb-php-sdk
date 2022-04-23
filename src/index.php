<?php

use Memuya\Fab\Fab;
use Memuya\Fab\RequestConfig\CardsConfig;

$fab = new Fab;

echo $fab->cards(new CardsConfig);