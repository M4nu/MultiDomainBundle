<?php
namespace M4nu\MultiDomainBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideRouteBasepathsCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('m4nu_multi_domain.backend_type_phpcr')) {
            return;
        }

        $routeBasePaths = $container->getParameter('cmf_routing.dynamic.persistence.phpcr.route_basepaths');
        $domains = $container->getParameter('m4nu_multi_domain.domains');

        $routeBasePathsWithLocale = array();

        foreach ($routeBasePaths as $routeBasePath) {
            foreach ($domains as $locale => $domain) {
                $routeBasePathsWithLocale[] = sprintf('%s/%s', $routeBasePath, $locale);
            }
        }

        $container
            ->getDefinition('cmf_routing.phpcr_candidates_prefix')
            ->replaceArgument(0, $routeBasePathsWithLocale)
        ;
    }
}
