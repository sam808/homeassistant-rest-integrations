<?php

$loader = (require_once '../vendor/autoload.php')->setPsr4("sam808\\", __DIR__ . "/../src/sam808/");

$tabuchi = new \sam808\Tabuchi();

$tabuchi->fetch();