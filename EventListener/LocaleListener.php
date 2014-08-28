<?php
namespace M4nu\MultiDomainBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocaleListener
{
    private $domains;

    public function __construct(array $domains)
    {
        $this->domains = $domains;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();
        $host = $request->getHost();

        if (false !== $locale = array_search($host, $this->domains)) {
            $request->setLocale($locale);
        }
    }
}
