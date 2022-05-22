<?php

use AleksandrovEugen\TestForm\App;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

require __DIR__ . '/../src/bootstrap.php';

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$app = new App($request);
$response = $app->run();

(new SapiEmitter())->emit($response);
