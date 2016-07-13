<?php

namespace denisristic\ExcelServiceProvider\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use denisristic\ExcelServiceProvider\Generator\ExcelDoctrine;
use denisristic\ExcelServiceProvider\Generator\Excel;

class ExcelServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['excel'] = function ($app) {
            if (isset($app['db'])) {
                return new ExcelDoctrine($app['db']);
            }

            return new Excel();
        };
    }

}
