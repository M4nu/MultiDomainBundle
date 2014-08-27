<?php
namespace M4nu\MultiDomainBundle\Resolver;

use Symfony\Component\HttpFoundation\RequestStack;

class MultiDomainBasePathResolver
{
    private $requestStack;
    private $routeBasepaths;

    function __construct(RequestStack $requestStack, array $routeBasepaths)
    {
        $this->requestStack = $requestStack;
        $this->routeBasepaths = $routeBasepaths;
    }

    public function getRouteBasepaths()
    {
        if ($request = $this->requestStack->getCurrentRequest()) {
            $domain = $request->getHost();

            $routeBasePaths = array();

            foreach ($this->routeBasepaths as $routeBasePath) {
                $routeBasePaths[] = sprintf('%s/%s', $routeBasePath, $domain);
            }

            return $routeBasePaths;
        }

        return $this->routeBasepaths;
    }
}
