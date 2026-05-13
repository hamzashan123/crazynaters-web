<?php

if (!isset($_ENV['APP_ENV_LOADED'])) {

    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $_ENV['APP_ENV_LOADED'] = true;
}