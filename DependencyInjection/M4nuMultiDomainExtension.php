<?php

namespace M4nu\MultiDomainBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class M4nuMultiDomainExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['persistence']['phpcr']['enabled']) {
            $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('services.xml');
            $loader->load('phpcr.xml');

            $container->setParameter($this->getAlias() . '.domains', $config['domains']);
            $container->setParameter($this->getAlias() . '.excluded_paths', $config['excluded_paths']);
            $container->setParameter($this->getAlias() . '.backend_type_phpcr', true);
        }
    }
}
