<?php

/**
 * This file is part of Sulu Megamenu Bundle.
 *
 * (c) The Cocktail Expericence S.L.
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\EventSubscriber;

use Sulu\Bundle\PageBundle\Document\PageDocument;
use Sulu\Component\DocumentManager\Event\PublishEvent;
use Sulu\Component\DocumentManager\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @author Pablo Lozano <lozanomunarriz@gmail.com>
 */
class PublishDocumentSubscriber implements EventSubscriberInterface
{
    private TagAwareCacheInterface $cache;

    public function __construct(TagAwareCacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public static function getSubscribedEvents(): array
    {
        return [Events::PUBLISH => 'onPublishDocument'];
    }

    public function onPublishDocument(PublishEvent $event): void
    {
        $document = $event->getDocument();

        if (!$document instanceof PageDocument) {
            return;
        }
        $this->cache->invalidateTags([$document->getUuid()]);
    }
}
