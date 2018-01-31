<?php

/**
 * @date    2018-01-31
 * @file    DefaultController.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks\Controllers;

use Murks\View\Renderer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController
{
    private $request;
    private $response;
    private $view;

    public function __construct(
        Request $request,
        Response $response,
        Renderer $view
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = $view;
    }

    public function index()
    {
        $html = $this->view->render(
            'index.html', [
                'name' => $this->request->query->get('name', 'Unknown')
            ]
        );

        return $this->response->setContent($html);
    }
}
