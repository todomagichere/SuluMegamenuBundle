<?php

namespace TheCocktail\Bundle\MegaMenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('sulu_megamenu');
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('menus')
                ->useAttributeAsKey('resourceKey')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('twig_global')->defaultTrue()->end()
                            ->scalarNode('title')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
