<?php

/**
 * @date    2018-01-31
 * @file    TwigRenderer.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks\View;

use Twig_Environment;

class TwigRenderer implements Renderer
{
    private $engine;

    public function __construct(Twig_Environment $engine)
    {
        $this->engine = $engine;
    }

    public function render($view, $data = []): string
    {
       return $this->engine->render($view, $data);
    }
}
