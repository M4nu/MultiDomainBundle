<?php
namespace M4nu\MultiDomainBundle\Resolver;

class MultiDomainBasePathResolver implements BasePathResolverInterface
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

    public function getPathHost($path)
    {
        foreach ($this->routeBasepaths as $routeBasePath) {
            foreach ($this->domains as $domain) {
                if (0 === strpos($path, sprintf('%s/%s', $routeBasePath, $domain))) {
                    return $domain;
                }
            }
        }

        return false;
    }
}
