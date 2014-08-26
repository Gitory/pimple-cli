<?php

namespace Gitory\PimpleCli;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Gitory\PimpleCli\ServiceCommandResolver;

class ServiceCommandServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['command.resolver'] = function ($app) {
            return new ServiceCommandResolver($app);
        };
    }
}
