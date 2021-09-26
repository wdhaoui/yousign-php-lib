<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wdhaoui_yousign');

        $rootNode
            ->children()
                ->scalarNode('base_uri')
                    ->info('The uri of the Yousign API. Must be defined.')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                  ->scalarNode('webapp_url')
                      ->info('The URL of YouSign webapp. Must be defined.')
                      ->cannotBeEmpty()
                      ->isRequired()
                  ->end()
                ->scalarNode('access_token')
                    ->info('The access token provided by Yousign. Must be defined.')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
