<?php

$loader = (require_once '../vendor/autoload.php')->setPsr4("sam808\\", __DIR__ . "/../src/sam808/");

$bluebot = new \sam808\BlueBot();

$bluebot->fetch();