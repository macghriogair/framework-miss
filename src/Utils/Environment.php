<?php

/**
 * @date    2018-01-31
 * @file    Environment.php
 * @author  Patrick Mac Gregor <macgregor.porta@gmail.com>
 */

declare(strict_types = 1);

namespace Murks\Utils;

class Environment
{
    const ENV_PROD = 'production';
    const ENV_LOCAL = 'local';

    public static function isProduction() : bool
    {
        if ($environment = getenv('APP_ENV')) {
            return self::ENV_PROD === $environment;
        }

        return true;
    }

    public static function isLocal() : bool
    {
        if ($environment = getenv('APP_ENV')) {
            return self::ENV_LOCAL === $environment;
        }

        return false;
    }
}
