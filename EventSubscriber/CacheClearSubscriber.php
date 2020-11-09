<?php

namespace TheCocktail\Bundle\MegaMenuBundle\EventSubscriber;

use Sulu\Bundle\WebsiteBundle\Event\CacheClearEvent;
use Sulu\Bundle\WebsiteBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use TheCocktail\Bundle\MegaMenuBundle\Builder\MenuBuilder;

class CacheClearSubscriber implements EventSubscriberInterface
{
    private TagAwareCacheInterface $cache;

    public function __construct(TagAwareCacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public static function getSubscribedEvents()
    {
        return [Events::CACHE_CLEAR  => 'onCacheClear'];
    }

    public function onCacheClear(CacheClearEvent $event)
    {
        $this->cache->invalidateTags([MenuBuilder::MENU_ALL]);
    }
}
