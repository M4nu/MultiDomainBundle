<?php

namespace M4nu\MultiDomainBundle\Doctrine\Phpcr;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\PrefixCandidates;
use Symfony\Component\HttpFoundation\Request;

/**
 * Host based strategy.
 */
class HostCandidates extends PrefixCandidates
{
    /**
     * @var array
     */
    protected $domains = [];

    /**
     * @var array
     */
    protected $routeBasepaths = [];

    public function __construct(array $prefixes, array $domains = [], ManagerRegistry $doctrine = null, $limit = 20, array $routeBasepaths)
    {
        parent::__construct($prefixes, array_keys($domains), $doctrine, $limit);
        $this->domains = $domains;
        $this->routeBasepaths = $routeBasepaths;
    }

    public function getCandidates(Request $request)
    {
        $candidates = parent::getCandidates($request);
        $host = $request->getHost();
        $locale = array_search($host, $this->domains);

        foreach ($candidates as $key => $candidate) {
            foreach ($this->routeBasepaths as $routeBasePath) {
                if (0 === strpos($candidate, $routeBasePath.'/'.$locale)) {
                    continue;
                }

                unset($candidates[$key]);
            }
        }

        return $candidates;
    }
}
