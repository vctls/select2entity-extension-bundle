<?php

namespace Vctls\Select2EntityExtensionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * {@inheritDoc}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vctls_select2_entity_extension');

        $rootNode
            ->children()
                ->scalarNode('searcher_namespace')->defaultValue('App\\Util\\')->end()
            ->end();
        
        return $treeBuilder;
    }
}
