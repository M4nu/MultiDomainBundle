<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use M4nu\MultiDomainBundle\Resolver\MultiDomainBasePathResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MultiDomainBasePathResolverTest extends \PHPUnit_Framework_TestCase
{
    private $routeBasepaths = array('/cms/routes', '/cms/routes2');
    private $domains = array('www.example.org', 'fr.example.org');

    public function testGetBasePathWithEmptyRequest()
    {
        $requestStack = new RequestStack();

        $resolver = new MultiDomainBasePathResolver($requestStack, $this->routeBasepaths, $this->domains);

        $this->assertEquals($resolver->getRouteBasepaths(), array(
            '/cms/routes/www.example.org',
            '/cms/routes/fr.example.org',
            '/cms/routes2/www.example.org',
            '/cms/routes2/fr.example.org',
        ));
    }

    public function testGetBasePathWithRequest()
    {
        $request = new Request(array(), array(), array(), array(), array(), array('HTTP_HOST' => 'www.example.org'));

        $requestStack = new RequestStack();
        $requestStack->push($request);

        $resolver = new MultiDomainBasePathResolver($requestStack, $this->routeBasepaths, $this->domains);

        $this->assertEquals($resolver->getRouteBasepaths(), array(
            '/cms/routes/www.example.org',
            '/cms/routes2/www.example.org',
        ));
    }
}
