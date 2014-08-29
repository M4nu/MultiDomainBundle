<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ODM\PHPCR\Event\MoveEventArgs;
use M4nu\MultiDomainBundle\EventListener\RouteListener;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

class RouteListenerTest extends \PHPUnit_Framework_TestCase
{
    private $routeBasePaths = array('/cms/routes', '/cms/routes2');
    private $domains = array('en' => 'www.example.org', 'fr' => 'fr.example.org');
    private $route;

    public function setup()
    {
        $this->route = new Route();
        $this->route->setId('/cms/routes/fr.example.org/home');
    }

    public function testUpdateHost()
    {
        $locale = 'fr';
        $host = 'fr.example.org';
        $dm = $this->getMockBuilder('Doctrine\ODM\PHPCR\DocumentManager')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $routeHostListener = new RouteListener($this->routeBasePaths, $this->domains);

        $route = $this->route;

        $event = new LifecycleEventArgs($route, $dm);
        $routeHostListener->postLoad($event);
        $this->assertEquals($host, $route->getHost());
        $this->assertEquals($locale, $route->getRequirement('_locale'));

        $event = new LifecycleEventArgs($route, $dm);
        $routeHostListener->postPersist($event);
        $this->assertEquals($host, $route->getHost());
        $this->assertEquals($locale, $route->getRequirement('_locale'));

        $event = new MoveEventArgs($route, $dm, null, null);
        $routeHostListener->postMove($event);
        $this->assertEquals($host, $route->getHost());
        $this->assertEquals($locale, $route->getRequirement('_locale'));
    }
}
