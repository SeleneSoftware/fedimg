<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapSubscriber implements EventSubscriberInterface
{
    protected $userRepository;

    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }

    public function onPrestaSitemapPopulate(SitemapPopulateEvent $event): void
    {
        $this->registerFeedUrls($event->getUrlContainer(), $event->getUrlGenerator());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'presta_sitemap.populate' => 'onPrestaSitemapPopulate',
        ];
    }

    public function registerFeedUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            $urls->addUrl(
                new UrlConcrete(
                    $router->generate(
                        'feed',
                        ['username' => $user->getUsername()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'feed'
            );
        }
    }
}
