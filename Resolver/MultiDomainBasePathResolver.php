<?php
namespace M4nu\MultiDomainBundle\Resolver;

use Symfony\Component\HttpFoundation\RequestStack;

class MultiDomainBasePathResolver
{
    private $requestStack;
    private $routeBasepaths;
    private $domains;

    function __construct(RequestStack $requestStack, array $routeBasepaths, array $domains)
    {
        $this->requestStack = $requestStack;
        $this->routeBasepaths = $routeBasepaths;
        $this->domains = $domains;
    }

    public function getRouteBasepaths()
    {
        if ($request = $this->requestStack->getCurrentRequest()) {
            return $this->appendDomains(array($request->getHost()));
        } else {
            return $this->appendDomains($this->domains);
        }
    }

    private function appendDomains(array $domains)
    {
        $routeBasePaths = array();

        foreach ($this->routeBasepaths as $routeBasePath) {
            foreach ($domains as $domain) {
                $routeBasePaths[] = sprintf('%s/%s', $routeBasePath, $domain);
            }
        }

        return $routeBasePaths;
    }
}
