<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\ResourceBundle\DependencyInjection\Driver;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Arnaud Langlade <aRn0D.dev@gmail.com>
 */
class DoctrineODMDriverSpec extends ObjectBehavior
{
    function let(ContainerBuilder $container)
    {
        $this->beConstructedWith($container, 'prefix', 'resource', 'default');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\ResourceBundle\DependencyInjection\Driver\DoctrineODMDriver');
    }

    function it_should_implement_database_interface()
    {
        $this->shouldHaveType('Sylius\Bundle\ResourceBundle\DependencyInjection\Driver\DatabaseDriverInterface');
    }

    function it_should_create_definition(ContainerBuilder $container)
    {
        $container->hasParameter("prefix.repository.resource.class")
            ->willReturn(true);

        $container->getParameter("prefix.repository.resource.class")
            ->shouldBeCalled();

        $container->setDefinition(
            'prefix.controller.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setDefinition(
            'prefix.repository.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setDefinition(
            'prefix.manager.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setDefinition(
            'prefix.factory.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $container->setDefinition(
            'prefix.event_dispatcher.resource',
            Argument::type('Symfony\Component\DependencyInjection\Definition')
        )->shouldBeCalled();

        $this->beConstructedWith($container, 'prefix', 'resource', 'default');

        $this->load(array(
            'model' => 'Sylius\Bundle\ResourceBundle\SyliusResourceBundle',
            'controller' => 'Sylius\Controller',
            'repository' => 'Sylius\Bundle\ResourceBundle\SyliusResourceBundle',
        ));
    }
}
