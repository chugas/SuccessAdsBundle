<?php

namespace Success\AdsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Success\AdsBundle\SuccessAdsBundle;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ads');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(SuccessAdsBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end()
        ;

        //$this->addClassesSection($rootNode);

        return $treeBuilder;
    }
    
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->arrayNode('evento')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('')->end()
                                ->scalarNode('controller')->defaultValue('')->end()
                                ->scalarNode('repository')->defaultValue('')->end()
                                ->scalarNode('form')->defaultValue('')->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end()
        ;
    }    
}
