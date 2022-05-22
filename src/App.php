<?php

namespace AleksandrovEugen\TestForm;

use AleksandrovEugen\TestForm\Controllers\FormController;
use AleksandrovEugen\TestForm\Repositories\FormRepository;
use AleksandrovEugen\TestForm\Services\FormService;
use Laminas\Diactoros\Response;
use League\Container\Container;
use League\Route\Router;
use League\Route\Strategy\ApplicationStrategy;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\Validator;

class App
{
    public function __construct(
        private RequestInterface $request
    ){}

    /**
     * @return ResponseInterface
     */
    public function run(): ResponseInterface
    {
        $container = $this->makeContainer();

        $strategy = (new ApplicationStrategy())->setContainer($container);
        $router   = (new Router())->setStrategy($strategy);

        $router->map('POST', '/form', FormController::class);

        return $router->dispatch($this->request);
    }

    /**
     * @return Container
     */
    protected function makeContainer(): Container
    {
        $container = new Container();

        $container->add(FormController::class)->addArguments([
            FormValidator::class,
            FormService::class,
        ]);
        $container->add(FormValidator::class)->addArguments([
            Validator::class,
            $this->request
        ]);
        $container->add(FormService::class)->addArgument(FormRepository::class);
        $container->add(Response::class);
        $container->add(FormValidator::class);
        $container->add(Validator::class);
        $container->add(FormRepository::class);

        return $container;
    }
}