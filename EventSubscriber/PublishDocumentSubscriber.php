<?php

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\EventSubscriber;

use Sulu\Bundle\PageBundle\Document\PageDocument;
use Sulu\Component\DocumentManager\Event\PublishEvent;
use Sulu\Component\DocumentManager\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

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
