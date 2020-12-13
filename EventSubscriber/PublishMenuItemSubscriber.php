<?php

/**
 * This file is part of Sulu Megamenu Bundle.
 *
 * (c) The Cocktail Experience S.L.
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\EventSubscriber;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TheCocktail\Bundle\MegaMenuBundle\Event\MenuEvent;

/**
 * @author Pablo Lozano <lozanomunarriz@gmail.com>
 */
class PublishMenuItemSubscriber implements EventSubscriberInterface
{
    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public static function getSubscribedEvents(): array
    {
        return [MenuEvent::PUBLISHED => 'onPublishMenuItem'];
    }

    public function onPublishMenuItem(MenuEvent $event): void
    {
        $menuItem = $event->getItem();

        $key = 'menu-' . $menuItem->getWebspace() . $menuItem->getResourceKey() . $menuItem->getLocale();
        $headersKey = 'headers-' . $menuItem->getWebspace() . $menuItem->getResourceKey() . $menuItem->getLocale();

        $this->adapter->deleteItem($key);
        $this->adapter->deleteItem($headersKey);
    }
}
