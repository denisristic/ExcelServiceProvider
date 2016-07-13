<?php

namespace denisristic\ExcelServiceProvider\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ExcelServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['excel'] = function ($app) {
            if (isset($app['db'])) {
                return new \denisristic\ExcelServiceProvider\Generator\ExcelDoctrine($app['db']);
            }

            return new \denisristic\ExcelServiceProvider\Generator\Excel();
        };
    }

}
