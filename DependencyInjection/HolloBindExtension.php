<?php

namespace Hollo\BindBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HolloBindExtension extends Extension
{
  /**
   * {@inheritDoc}
   */
  public function load(array $configs, ContainerBuilder $container)
  {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.yml');
    $loader->load('listener.yml');

    $container->setParameter('hollo_bind.nameservers', $config['nameservers']);
    $container->setParameter('hollo_bind.hostmaster', $config['hostmaster']);
    $container->setParameter('hollo_bind.config_file', $config['config_file']);
    $container->setParameter('hollo_bind.config_path', $config['config_path']);
    $container->setParameter('hollo_bind.zone_path', $config['zone_path']);
    $container->setParameter('hollo_bind.bind_init', $config['bind_init']);
  }
}
