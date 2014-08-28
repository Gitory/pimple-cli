<?php

namespace spec\Gitory\PimpleCli;

use PhpSpec\ObjectBehavior;
use Pimple\Container;


class ServiceCommandResolverSpec extends ObjectBehavior
{

    public function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Gitory\PimpleCli\ServiceCommandResolver');
    }


    public function it_resolve_commands_with_a_container_without_commands(Container $container)
    {
        $container->keys()->willReturn([]);
        $this->commands()->shouldReturn([]);
    }

    public function it_does_not_resolve_services_that_are_not_commands(Container $container)
    {
        $container->keys()->willReturn(['foobar']);
        $this->commands()->shouldReturn([]);
    }

    public function it_resolve_commands(Container $container, $command1, $command2)
    {
        $container->keys()->willReturn(['test1.command', 'test2.command']);
        $container->offsetGet('test1.command')->willReturn($command1);
        $container->offsetGet('test2.command')->willReturn($command2);
        $this->commands()->shouldReturn([$command1, $command2]);
    }
}
