<?php

namespace Gitory\PimpleCli;

use Pimple\Container;

class ServiceCommandResolver
{
    /**
     * Service command container
     * @var Container
     */
    private $container;

    /**
     * @var array of Command
     */
    private $commands;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function commands()
    {
        if($this->commands === null) {
            $this->commands = [];

            foreach($this->container->keys() as $serviceName) {
                if(preg_match('/\.command$/', $serviceName)) {
                    $this->commands[] = $this->container[$serviceName];
                }
            }
        }

        return $this->commands;
    }
}
