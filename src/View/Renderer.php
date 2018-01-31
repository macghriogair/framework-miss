<?php

/**
 * @date    2018-01-31
 * @file    Renderer.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks\View;

interface Renderer
{
    public function render($view, $data = []) : string;
}
