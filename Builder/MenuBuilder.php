<?php

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\Builder;

use Sulu\Component\DocumentManager\Exception\DocumentNotFoundException;
use TheCocktail\Bundle\MegaMenuBundle\Entity\MenuItem;
use TheCocktail\Bundle\MegaMenuBundle\Exception\NotPublishedException;
use TheCocktail\Bundle\MegaMenuBundle\Repository\MenuItemRepository;
use FOS\HttpCacheBundle\Http\SymfonyResponseTagger;
use Sulu\Component\Content\Compat\Structure\StructureBridge;
use Sulu\Component\Content\Mapper\ContentMapperInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class MenuBuilder
{
    private MenuItemRepository $repository;
    private ContentMapperInterface $contentMapper;
    private TagAwareCacheInterface $cache;
    private SymfonyResponseTagger $responseTagger;

    private array $tags;

    public function __construct(
        MenuItemRepository $repository,
        ContentMapperInterface $contentMapper,
        TagAwareCacheInterface $cache,
        SymfonyResponseTagger $responseTagger
    ) {
        $this->repository = $repository;
        $this->contentMapper = $contentMapper;
        $this->cache = $cache;
        $this->responseTagger = $responseTagger;
    }

    public function build(string $webspace, string $resourceKey, string $locale): array
    {
        $this->tags = [];

        $key = 'menu-' . $webspace . $resourceKey . $locale;
        $headersKey = 'headers-' . $webspace . $resourceKey . $locale;

        $menu = $this->cache->get($key, function (ItemInterface $item) use ($webspace, $resourceKey, $locale): array {
            $menuItems = $this->repository->findBy([
                'webspace' => $webspace,
                'resourceKey' => $resourceKey,
                'locale' => $locale,
                'parent' => null
            ], ['position' => 'ASC'], PHP_INT_MAX);

            $list = $this->recursiveList($menuItems);
            $item->tag($this->tags);

            return $list;
        });

        $headersTags = $this->cache->get($headersKey, function (ItemInterface $item) {
            $item->tag($this->tags);
            return $this->tags;
        });

        $this->responseTagger->addTags($headersTags);

        return $menu;
    }

    /**
     * @param MenuItem[] $menuItems
     * @return array
     */
    private function recursiveList(array $menuItems): array
    {
        usort($menuItems, function($a, $b) {
            return ($a->getPosition() === $b->getPosition()) ? 0 : (($a->getPosition() < $b->getPosition()) ? -1: 1);
        });
        $data = [];
        foreach ($menuItems as $menuItem) {
            try {
                $url = $this->resolveUrl($menuItem);
            } catch (NotPublishedException|DocumentNotFoundException $exception) {
                continue;
            }
            $item = [
                'id' => $menuItem->getId(),
                'title' => $menuItem->getTitle(),
                'url' => $url,
                'hasChildren' => $menuItem->hasChildren()
            ];
            if ($menuItem->getChildren()->count()) {
                $item['children'] = $this->recursiveList($menuItem->getChildren()->toArray());
            }
            $data[] = $item;
        }
        return $data;
    }

    private function resolveUrl(MenuItem $item): ?string
    {
        if (!$uuid = $item->getUuid()) {
            return $item->getLink() ?? null;
        }
        $structure = $this->contentMapper->load($uuid, $item->getResourceKey(), $item->getLocale());
        if (!$structure->getPublishedState()) {
            throw new NotPublishedException();
        }
        if (!$structure instanceof StructureBridge) {
            return null;
        }
        $this->tags[] = $structure->getUuid();

        return $structure->getResourceLocator();
    }
}
