<?php

namespace spec\Gitory\PimpleCli;

use PhpSpec\ObjectBehavior;
use Pimple\Container;
use Prophecy\Argument;

class ServiceCommandServiceProviderSpec extends ObjectBehavior
{

    public function let(Container $container)
    {
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Gitory\PimpleCli\ServiceCommandServiceProvider');
    }

    public function it_register_service_command_resolver(Container $container)
    {
         $container->offsetSet('command.resolver', Argument::Any())->shouldBeCalled();
         $this->register($container);
    }
}
