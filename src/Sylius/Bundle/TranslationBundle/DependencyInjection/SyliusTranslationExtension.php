<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\TranslationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * @author Gonzalo Vilaseca <gvilaseca@reiss.co.uk>
 */
class SyliusTranslationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $container->setParameter('sylius.translation.default_locale', $config[1]['default_locale']);
        $container->setAlias('sylius.translation.locale_provider', $config[1]['locale_provider']);
    }
}
