<?php

$loader = (require_once '../vendor/autoload.php')->setPsr4("sam808\\", __DIR__ . "/../src/sam808/");

$solark = new \sam808\Solark();

$solark->fetch();