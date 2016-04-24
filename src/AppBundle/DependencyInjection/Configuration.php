<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('app', 'array');

        $rootNode
            ->children()
                ->scalarNode('date_format')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
