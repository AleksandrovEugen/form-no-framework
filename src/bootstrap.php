<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require __DIR__.'/../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . DIRECTORY_SEPARATOR . '..');
$dotenv->safeLoad();

// Register error handler
$whoops = new Run();

if ($_ENV['APP_ENV'] === 'dev') {
    $whoops->pushHandler(new PrettyPageHandler());
} else {
    $whoops->pushHandler(function($e) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['message'=> 'Internal server error']);
    });
}

$whoops->register();
