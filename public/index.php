<?php

require_once __DIR__.'/../vendor/autoload.php';

use Project\Application;

$app = Application::getInstance();
$app->setEnvironment('dev');
$app->handleRequest();