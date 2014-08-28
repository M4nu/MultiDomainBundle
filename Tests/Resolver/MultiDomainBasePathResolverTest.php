<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use M4nu\MultiDomainBundle\Resolver\MultiDomainBasePathResolver;

class MultiDomainBasePathResolverTest extends \PHPUnit_Framework_TestCase
{
    private $routeBasepaths = array('/cms/routes', '/cms/routes2');
    private $domains = array('www.example.org', 'fr.example.org');
    private $resolver;

    public function setup()
    {
        $this->resolver = new MultiDomainBasePathResolver($this->routeBasepaths, $this->domains);
    }

    public function testGetBasePath()
    {
        $this->assertEquals(array(
            '/cms/routes/www.example.org',
            '/cms/routes/fr.example.org',
            '/cms/routes2/www.example.org',
            '/cms/routes2/fr.example.org',
        ), $this->resolver->getRouteBasepaths());
    }

    public function getRouteHostDataProvider()
    {
        return array(
            array('/cms/routes/www.example.org/home', 'www.example.org'),
            array('/cms/routes/www.example.org', 'www.example.org'),
            array('/cms/routes/www.example.org', 'www.example.org'),
            array('/cms/routes/fr.example.org', 'fr.example.org'),
            array('/cms/routes/fr.example.uk', false),
        );
    }

    /**
     * @dataProvider getRouteHostDataProvider
     */
    public function testGetRouteHost($id, $host)
    {
        $this->assertEquals($host, $this->resolver->getPathHost($id));
    }
}
