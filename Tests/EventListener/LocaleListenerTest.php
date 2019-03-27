<?php
namespace M4nu\MultiDomainBundle\Tests\Resolver;

use M4nu\MultiDomainBundle\EventListener\LocaleListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocaleListenerTest extends \PHPUnit\Framework\TestCase
{
    private $domains = array(
        'en' => 'en.example.org',
        'fr' => 'fr.example.org',
    );

    public function onKernelRequestDataProvider()
    {
        return array(
            array('www.example.org', 'en'),
            array('en.example.org', 'en'),
            array('fr.example.org', 'fr'),
        );
    }

    /**
     * @dataProvider onKernelRequestDataProvider
     */
    public function testOnKernelRequest($host, $locale)
    {
        $kernel = $this->createMock('Symfony\Component\HttpKernel\HttpKernelInterface');
        $request = new Request(array(), array(), array(), array(), array(), array('HTTP_HOST' => $host));
        $event = new GetResponseEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST);

        $localeListener = new LocaleListener($this->domains);
        $localeListener->onKernelRequest($event);

        $this->assertEquals($locale, $request->getLocale());
    }
}
