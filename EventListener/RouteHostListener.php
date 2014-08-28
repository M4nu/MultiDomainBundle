<?php
namespace M4nu\MultiDomainBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\PHPCR\Event\MoveEventArgs;
use M4nu\MultiDomainBundle\Resolver\BasePathResolverInterface;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

/**
 * Update routes host attribute when they are created or moved
 */
class RouteHostListener
{
    private $basePathResolver;

    public function __construct(BasePathResolverInterface $basePathResolver)
    {
        $this->basePathResolver = $basePathResolver;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->updateHost($args);
    }

    public function preMove(MoveEventArgs $args)
    {
        $this->updateHost($args);
    }

    private function updateHost(LifecycleEventArgs $args)
    {
        $document = $args->getObject();

        if (!$document instanceof Route) {
            return;
        }

        $id = $args instanceof MoveEventArgs ? $args->getTargetPath() : $document->getId();

        if ($host = $this->basePathResolver->getPathHost($id)) {
            $document->setHost($host);
        }
    }
}
