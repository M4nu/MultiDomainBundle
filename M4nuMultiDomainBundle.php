<?php

namespace M4nu\MultiDomainBundle;

use M4nu\MultiDomainBundle\DependencyInjection\Compiler\OverrideRouteBasepathsCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class M4nuMultiDomainBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new OverrideRouteBasepathsCompilerPass());
    }
}
