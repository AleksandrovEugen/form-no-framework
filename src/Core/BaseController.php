<?php

namespace AleksandrovEugen\TestForm\Core;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class BaseController
{
    public function sendJsonResponse(array $data, int $statusCode = 200): ResponseInterface
    {
        return new JsonResponse(
            $data,
            $statusCode,
            ['Content-Type' => ['application/hal+json']]
        );
    }
}