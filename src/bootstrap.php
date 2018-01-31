<?php

/**
 * @date    2018-01-31
 * @file    bootstrap.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks;

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Murks\Utils\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as Whoops;

error_reporting(E_ALL);

/**
 * Source .env
 */
try {
    $dotenv = new Dotenv(__DIR__ . '/..');
    $dotenv->load();
} catch (\Exception $e) {
    echo 'Whoops! Something went wrong.';
    exit(1);
}

/**
* Register the error handler
*/
$whoops = new Whoops();
if (! Environment::isProduction()) {
    $whoops->pushHandler(new PrettyPageHandler);
} else {
    $whoops->pushHandler(function($e){
        echo 'Whoops! Something went wrong.';
    });
}
$whoops->register();

$injector = include('di.php');

/**
 * Create Request and Response instance
 */

/** @var Request$request */
$request = $injector->make(Request::class);
/** @var Response $response */
$response = $injector->make(Response::class);

/**
 * Routing
 */
$routeDefinitionCallback = function (RouteCollector $r) {
    $routes = include('routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], $route[2]);
    }
};

$dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response->setContent('404 - Page not found');
        $response->setStatusCode(404);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response->setContent('405 - Method not allowed');
        $response->setStatusCode(405);
        break;
    case Dispatcher::FOUND:
        $className = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];


        $class = $injector->make($className);
        $class->$method($vars);
        break;
}

$response->send();
