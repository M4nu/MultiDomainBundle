<?php
namespace M4nu\MultiDomainBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\ExpressionLanguage\Expression;

class OverrideRouteBasepathsCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $basePathResolverExpression = new Expression('service("m4nu_multi_domain.base_path_resolver").getRouteBasepaths()');

        $container
            ->getDefinition('cmf_routing.phpcr_candidates_prefix')
            ->replaceArgument(0, $basePathResolverExpression)
        ;

        $container
            ->getDefinition('cmf_routing.initializer')
            ->replaceArgument(1, $basePathResolverExpression)
        ;
    }
}
