<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Component\Inventory\Factory;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Inventory\Model\InventoryUnitInterface;
use Sylius\Component\Inventory\Model\StockableInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class InventoryUnitFactorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Component\Inventory\Factory\InventoryUnitFactory');
    }

    function it_is_a_resource_factory()
    {
        $this->shouldHaveType('Sylius\Component\Resource\Factory\ResourceFactory');
    }

    function it_implements_Sylius_inventory_unit_factory_interface()
    {
        $this->shouldImplement('Sylius\Component\Inventory\Factory\InventoryUnitFactoryInterface');
    }

    function it_throws_exception_if_given_quantity_is_less_than_1(StockableInterface $stockable)
    {
        $this
            ->shouldThrow('InvalidArgumentException')
            ->duringCreateForStockable($stockable, -2)
        ;
    }
}
