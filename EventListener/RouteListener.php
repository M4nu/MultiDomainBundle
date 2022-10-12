<?php

namespace M4nu\MultiDomainBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\PHPCR\Event\MoveEventArgs;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class RouteListener
{
    private $routeBasePaths;

    private $domains;

    public function __construct(array $routeBasePaths, array $domains)
    {
        $this->routeBasePaths = $routeBasePaths;
        $this->domains = $domains;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->updateRoute($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRoute($args);
    }

    public function postMove(MoveEventArgs $args)
    {
        $this->updateRoute($args);
    }

    private function updateRoute(LifecycleEventArgs $args)
    {
        $document = $args->getObject();

        if (!$document instanceof Route) {
            return;
        }

        foreach ($this->routeBasePaths as $routeBasePath) {
            foreach ($this->domains as $locale => $domain) {
                if (0 === strpos($document->getId(), sprintf('%s/%s', $routeBasePath, $locale))) {
                    $document
                        ->setHost($domain)
                        ->setDefault('_locale', $locale)
                        ->setRequirement('_locale', $locale)
                    ;

                    return;
                }
            }
        }
    }
}
