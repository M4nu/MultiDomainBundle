<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\PHPCR\Event\MoveEventArgs;
use M4nu\MultiDomainBundle\EventListener\RouteHostListener;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class RouteHostListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testUpdateHost()
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
        $routeHostListener->postLoad($event);
        $this->assertEquals($host, $document->getHost());

        $document = new Route();
        $event = new LifecycleEventArgs($document, $dm);
        $routeHostListener->postPersist($event);
        $this->assertEquals($host, $document->getHost());

        $document = new Route();
        $event = new MoveEventArgs($document, $dm, null, null);
        $routeHostListener->postMove($event);
        $this->assertEquals($host, $document->getHost());
    }
}
