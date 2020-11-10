<?php

/**
 * This file is part of Sulu Megamenu Bundle.
 *
 * (c) The Cocktail Expericence S.L.
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace TheCocktail\Bundle\MegaMenuBundle\EventSubscriber;

use Sulu\Bundle\WebsiteBundle\Event\CacheClearEvent;
use Sulu\Bundle\WebsiteBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use TheCocktail\Bundle\MegaMenuBundle\Builder\MenuBuilder;

/**
 * @author Pablo Lozano <lozanomunarriz@gmail.com>
 */
class CacheClearSubscriber implements EventSubscriberInterface
{
    private TagAwareCacheInterface $cache;

    public function __construct(TagAwareCacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public static function getSubscribedEvents(): array
    {
        return [Events::CACHE_CLEAR  => 'onCacheClear'];
    }

    public function onCacheClear(CacheClearEvent $event): void
    {
        $this->cache->invalidateTags([MenuBuilder::MENU_ALL]);
    }
}
