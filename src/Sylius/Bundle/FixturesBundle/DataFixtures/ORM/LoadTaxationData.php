<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\FixturesBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\FixturesBundle\DataFixtures\DataFixture;
use Sylius\Component\Core\Model\TaxRateInterface;
use Sylius\Component\Taxation\Model\TaxCategoryInterface;

/**
 * Basic taxation fixtures.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class LoadTaxationData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $productOptionManager)
    {
        $taxCategoryManager = $this->getTaxCategoryManager();
        $taxRateManager = $this->getTaxRateManager();

        $taxableGoods = $this->createTaxCategory('Taxable goods', 'Default taxation category');

        $taxCategoryManager->persist($taxableGoods);

        $taxRate = $this->createTaxRate('EU VAT', 'EU', 0.23);
        $taxRate->setCategory($taxableGoods);

        $taxRateManager->persist($taxRate);

        $taxableGoods->addRate($this->createTaxRate('US Sales Tax', 'USA', 0.08));
        $taxRate->setCategory($taxableGoods);

        $taxRateManager->persist($taxRate);

        $taxableGoods->addRate($this->createTaxRate('No tax', 'Rest of World', 0.00));
        $taxRate->setCategory($taxableGoods);

        $taxRateManager->persist($taxRate);

        $taxRateManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 30;
    }

    /**
     * Create tax category.
     *
     * @param string $name
     * @param string $description
     *
     * @return TaxCategoryInterface
     */
    protected function createTaxCategory($name, $description)
    {
        /* @var $category TaxCategoryInterface */
        $category = $this->getTaxCategoryFactory()->createNew();
        $category->setName($name);
        $category->setDescription($description);

        $this->setReference('Sylius.TaxCategory.'.$name, $category);

        return $category;
    }

    /**
     * Create tax rate.
     *
     * @param string  $name
     * @param string  $zoneName
     * @param float   $amount
     * @param Boolean $includedInPrice
     * @param string  $calculator
     *
     * @return TaxRateInterface
     */
    protected function createTaxRate($name, $zoneName, $amount, $includedInPrice = false, $calculator = 'default')
    {
        /* @var $rate TaxRateInterface */
        $rate = $this->getTaxRateFactory()->createNew();
        $rate->setName($name);
        $rate->setZone($this->getZoneByName($zoneName));
        $rate->setAmount($amount);
        $rate->setIncludedInPrice($includedInPrice);
        $rate->setCalculator($calculator);

        $this->setReference('Sylius.TaxRate.'.$name, $rate);

        return $rate;
    }
}
