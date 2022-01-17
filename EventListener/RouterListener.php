<?php
namespace M4nu\MultiDomainBundle\EventListener;

use Symfony\Cmf\Component\Routing\Event\RouterGenerateEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class RouterListener
{
    private $router;

    private $routeBasePaths;

    private $domains;

    public function __construct(RouterInterface $router, array $routeBasePaths, array $domains)
    {
        $this->router = $router;
        $this->routeBasePaths = $routeBasePaths;
        $this->domains = $domains;
    }

    public function onGenerate(RouterGenerateEvent $event)
    {
        // If _locale parameter exists, use corresponding domain and force absolute URL
        if ($locale = $event->getParameters()['_locale'] ?? null) {
            $domain = $this->domains[$locale];

            $event->setReferenceType(UrlGeneratorInterface::ABSOLUTE_URL);
            $this->updateRouterContext($domain, $locale);

            return;
        }

        // Else, search what is current route locale
        $route = $event->getRoute();

        if (!is_string($route)) {
            return;
        }

        foreach ($this->routeBasePaths as $routeBasePath) {
            foreach ($this->domains as $locale => $domain) {
                if (0 === strpos($route, sprintf('%s/%s', $routeBasePath, $locale))) {
                    $this->updateRouterContext($domain, $locale);

                    return;
                }
            }
        }
    }

    private function updateRouterContext(string $host, string $locale): void
    {
        $this->router
            ->getContext()
            ->setHost($host)
            ->setParameter('_locale', $locale)
        ;
    }
}
