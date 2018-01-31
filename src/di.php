<?php

/**
 * @date    2018-01-31
 * @file    di.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks;

use Auryn\Injector;
use Murks\Utils\Environment;
use Murks\View\Renderer;
use Murks\View\TwigRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;
use Twig_Loader_Filesystem;

$injector = new Injector;

// Request
$injector->share(Request::class);
$injector->delegate(Request::class, function () {
    return Request::createFromGlobals();
});

// Response
$injector->share(Response::class);

// Views
$injector->alias(Renderer::class, TwigRenderer::class);
$injector->share(TwigRenderer::class);
$injector->delegate(Twig_Environment::class, function () {
    $templatePath  = __DIR__ . '/../resources/views';
    $cachePath = __DIR__ . '/../storage/cache/views';

    $loader = new Twig_Loader_Filesystem($templatePath);

    return new Twig_Environment($loader, [
        'cache' => Environment::isProduction() ? $cachePath : false,
        'debug' => ! Environment::isProduction(),
    ]);
});

return $injector;
