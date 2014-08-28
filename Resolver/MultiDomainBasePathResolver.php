<?php
namespace M4nu\MultiDomainBundle\Resolver;

class MultiDomainBasePathResolver
{
    private $routeBasepaths;
    private $domains;

    function __construct($routeBasepaths, $domains)
    {
        $this->routeBasepaths = $routeBasepaths;
        $this->domains = $domains;
    }

    public function getRouteBasepaths()
    {
        $routeBasePaths = array();

        foreach ($this->routeBasepaths as $routeBasePath) {
            foreach ($this->domains as $domain) {
                $routeBasePaths[] = sprintf('%s/%s', $routeBasePath, $domain);
            }
        }

        return $routeBasePaths;
    }
}
