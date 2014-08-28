<?php
namespace M4nu\MultiDomainBundle\Resolver;

interface BasePathResolverInterface
{
    public function getRouteBasepaths();

    public function getPathHost($path);
} 
