<?php

namespace Hollo\BindBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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
        $rootNode = $treeBuilder->root('hollo_bind');

        $rootNode
          ->children()
            ->scalarNode('ns1')->defaultValue('ns1.example.com')->end()
            ->scalarNode('ns2')->defaultValue('ns2.example.com')->end()
            ->scalarNode('hostmaster')->defaultValue('ns1.example.com')->end()
          ->end();

        return $treeBuilder;
    }
}
