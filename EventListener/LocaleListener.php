<?php
namespace M4nu\MultiDomainBundle\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LocaleListener
{
    private $domains;

    private $excludedPaths;

    public function __construct(array $domains, ?string $excludedPaths)
    {
        $this->domains = $domains;
        $this->excludedPaths = $excludedPaths;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        if (null !== $this->excludedPaths && preg_match('#'.$this->excludedPaths.'#', $request->getPathInfo())) {
            return;
        }

        $host = $request->getHost();

        if (false !== $locale = array_search($host, $this->domains)) {
            $request->setLocale($locale);
            $request->attributes->set('_locale', $locale);
        }
    }
}
