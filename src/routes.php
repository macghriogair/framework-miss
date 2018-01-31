<?php

/**
 * @date    2018-01-31
 * @file    routes.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks;

return [
    ['GET', '/', [ 'Murks\Controllers\DefaultController', 'index']],
    ['GET', '/another-route', function () {
        echo 'This works too';
    }],
];
