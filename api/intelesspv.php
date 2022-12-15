<?php

$loader = (require_once '../vendor/autoload.php')->setPsr4("sam808\\", __DIR__ . "/../src/sam808/");

$intelesspv = new \sam808\IntelessPV();

$intelesspv->fetch();