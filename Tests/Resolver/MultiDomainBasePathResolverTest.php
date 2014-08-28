<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use M4nu\MultiDomainBundle\Resolver\MultiDomainBasePathResolver;

class MultiDomainBasePathResolverTest extends \PHPUnit_Framework_TestCase
{
    private $routeBasepaths = array('/cms/routes', '/cms/routes2');
    private $domains = array('www.example.org', 'fr.example.org');

    public function testGetBasePath()
    {
        $resolver = new MultiDomainBasePathResolver($this->routeBasepaths, $this->domains);

        $this->assertEquals(array(
            '/cms/routes/www.example.org',
            '/cms/routes/fr.example.org',
            '/cms/routes2/www.example.org',
            '/cms/routes2/fr.example.org',
        ), $resolver->getRouteBasepaths());
    }
}
