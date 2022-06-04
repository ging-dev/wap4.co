<?php

use FrameworkX\App;

require_once __DIR__.'/../vendor/autoload.php';

$app = new App();

$app->any('/[{uri:.+}]', TwigMiddware::class, TwigController::class);

$app->run();
