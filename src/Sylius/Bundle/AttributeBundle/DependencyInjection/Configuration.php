<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AttributeBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sylius_attribute');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end()
        ;

        $this->addClassesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds `resources` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('subject')->isRequired()->end()
                            ->arrayNode('attribute')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->arrayNode('classes')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->scalarNode('model')->isRequired()->end()
                                            ->scalarNode('interface')->isRequired()->end()
                                            ->scalarNode('controller')->defaultValue('Sylius\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                            ->scalarNode('repository')->cannotBeEmpty()->end()
                                            ->scalarNode('factory')->end()
                                            ->arrayNode('form')
                                                ->addDefaultsIfNotSet()
                                                ->children()
                                                    ->scalarNode('default')->defaultValue('Sylius\Bundle\AttributeBundle\Form\Type\AttributeType')->end()
                                                    ->scalarNode('choice')->defaultValue('Sylius\Bundle\ResourceBundle\Form\Type\ResourceChoiceType')->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                    ->arrayNode('validation_groups')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->arrayNode('default')
                                                ->prototype('scalar')->end()
                                                ->defaultValue(array('sylius'))
                                            ->end()
                                        ->end()
                                    ->end()
                                    ->arrayNode('translation')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->arrayNode('classes')
                                                ->addDefaultsIfNotSet()
                                                ->children()
                                                    ->scalarNode('model')->defaultValue('Sylius\Component\Archetype\Model\AttributeTranslation')->end()
                                                    ->scalarNode('interface')->defaultValue('Sylius\Component\Archetype\Model\AttributeTranslationInterface')->end()
                                                    ->scalarNode('controller')->defaultValue('Sylius\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                                    ->scalarNode('repository')->end()
                                                    ->arrayNode('form')
                                                        ->addDefaultsIfNotSet()
                                                        ->children()
                                                            ->scalarNode('default')->defaultValue('Sylius\Bundle\AttributeBundle\Form\Type\AttributeTranslationType')->end()
                                                        ->end()
                                                    ->end()
                                                ->end()
                                            ->end()
                                            ->arrayNode('validation_groups')
                                                ->addDefaultsIfNotSet()
                                                ->children()
                                                    ->arrayNode('default')
                                                        ->prototype('scalar')->end()
                                                        ->defaultValue(array('sylius'))
                                                    ->end()
                                                ->end()
                                            ->end()
                                            ->arrayNode('fields')
                                                ->prototype('scalar')->end()
                                                ->defaultValue(array('presentation'))
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('attribute_value')
                                ->isRequired()
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->arrayNode('classes')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->scalarNode('model')->isRequired()->end()
                                            ->scalarNode('interface')->isRequired()->end()
                                            ->scalarNode('controller')->defaultValue('Sylius\Bundle\ResourceBundle\Controller\ResourceController')->end()
                                            ->scalarNode('repository')->cannotBeEmpty()->end()
                                            ->arrayNode('form')
                                                ->addDefaultsIfNotSet()
                                                ->children()
                                                    ->scalarNode('default')->defaultValue('Sylius\Bundle\AttributeBundle\Form\Type\AttributeValueType')->end()
                                                ->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                    ->arrayNode('validation_groups')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->arrayNode('default')
                                                ->prototype('scalar')->end()
                                                ->defaultValue(array('sylius'))
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
