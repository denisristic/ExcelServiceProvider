<?php

namespace denisristic\ExcelServiceProvider\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ExcelServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['excel'] = $app->share(function ($app) {
            if (isset($app['db'])) {
                return new \denisristic\ExcelServiceProvider\Generator\ExcelDoctrine($app['db']);
            }

            return new \denisristic\ExcelServiceProvider\Generator\Excel();
        });
    }

    public function boot(Application $app)
    {
    }
}
