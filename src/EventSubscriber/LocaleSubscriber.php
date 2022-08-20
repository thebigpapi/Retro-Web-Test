<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class LocaleSubscriber implements EventSubscriberInterface
{
    // Default locale
    private $defaultLocale;
    private $params;

    public function __construct(ContainerBagInterface $params, string $defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
        $this->params = $params;
    }

    private function getPreferedLocale(array $clientLangs)
    {
        $serverLangs = explode('|', $this->params->get('app.locales'));

        if (($max = count($clientLangs)) > 0) {
            for ($i = 0; $i < $max; $i++) {
                if (in_array(substr($clientLangs[$i], 0, 2), $serverLangs)) {
                    return substr($clientLangs[$i], 0, 2);
                }
            }
        }
        return $this->defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            $request->setLocale($this->getPreferedLocale($request->getLanguages()));
            return;
        }

        // Checking if the locale is given through URL parameter
        if ($locale = $request->query->get('_locale')) {
            $request->setLocale($locale);
        } else {
            // Get client's favorite supported language
            $locale = $this->getPreferedLocale($request->getLanguages());

            // Or use the one given through the session
            $request->setLocale($request->getSession()->get('_locale', $locale));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // Defining a high level of priority
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
