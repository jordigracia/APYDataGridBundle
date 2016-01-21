<?php
/*
 *
 * (c) Jordi Gracia <j.gracia83@gmail.com>
 *
 */
namespace APY\DataGridBundle\DependencyInjection;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class JordiGraciaDatagridExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processedConfig = $this->processConfiguration( $configuration, $configs );
        
        $container->setParameter( 'jordigracia_datagrid.url_protocol', $processedConfig[ 'url_protocol' ];

    }
}
