<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\PHPCR\Event\MoveEventArgs;
use M4nu\MultiDomainBundle\EventListener\RouteHostListener;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class RouteHostListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testPostPersistAndPostMove()
    {
        $host = 'fr.example.org';
        $dm = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock();
        $basePathResolver = $this->getMock('M4nu\MultiDomainBundle\Resolver\BasePathResolverInterface');
        $basePathResolver
            ->expects($this->any())
            ->method('getPathHost')
            ->will($this->returnValue($host))
        ;


        $routeHostListener = new RouteHostListener($basePathResolver);

        $document = new Route();
        $event = new LifecycleEventArgs($document, $dm);

        $routeHostListener->prePersist($event);

        $this->assertEquals($host, $document->getHost());

        $document = new Route();
        $event = new MoveEventArgs($document, $dm, null, null);

        $routeHostListener->preMove($event);

        $this->assertEquals($host, $document->getHost());
    }
}
