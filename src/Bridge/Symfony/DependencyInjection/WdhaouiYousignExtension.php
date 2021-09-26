<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Bridge\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class WdhaouiYousignExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $config['headers']['authorization'] = 'Bearer '.$config['access_token'];
        unset($config['access_token']);

        $clientDefinition = $container->getDefinition('wdhaoui_yousign.client');
        $defaultConfig = $clientDefinition->getArgument('$config');

        $container->setParameter('wdhaoui_yousign.webapp_url', $config['webapp_url']);

        $clientDefinition->setArgument('$config', \array_merge_recursive($defaultConfig, $config));
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'wdhaoui_yousign';
    }
}
