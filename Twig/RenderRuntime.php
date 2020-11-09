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

namespace TheCocktail\Bundle\MegaMenuBundle\Twig;

use Sulu\Component\Webspace\Analyzer\Attributes\RequestAttributes;
use Sulu\Component\Webspace\Webspace;
use Symfony\Component\HttpFoundation\RequestStack;
use TheCocktail\Bundle\MegaMenuBundle\Builder\MenuBuilder;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * @author Pablo Lozano <lozanomunarriz@gmail.com>
 */
class RenderRuntime implements RuntimeExtensionInterface
{
    private MenuBuilder $builder;
    private Environment $twig;
    private RequestStack $requestStack;

    public function __construct(
        MenuBuilder $builder,
        Environment $twig,
        RequestStack $requestStack
    ) {
        $this->builder = $builder;
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    public function render(string $resourceKey, string $template = null, string $webspace = null, string $locale = null): void
    {
        $webspace = $webspace ?? $this->getWebspaceKey();
        $locale = $locale ?? $this->getLocale();

        if (null === $webspace || $locale === null) {
            return;
        }

        $items = $this->builder->build($webspace, $resourceKey, $locale);

        $this->twig->display($template ?? '@SuluMegamenu/section.html.twig', ['items' => $items]);
    }

    public function get(string $resourceKey, string $webspace = null, string $locale = null): ?array
    {
        $webspace = $webspace ?? $this->getWebspaceKey();
        $locale = $locale ?? $this->getLocale();

        if (null === $webspace || $locale === null) {
            return null;
        }

        return $this->builder->build($webspace, $resourceKey, $locale);
    }

    private function getWebspaceKey(): ?string
    {
        if (!$request = $this->requestStack->getCurrentRequest()) {
            return null;
        }

        if (!$attributes = $request->attributes->get('_sulu')) {
            return null;
        }

        /** @var RequestAttributes $attributes */
        if (!$webspace = $attributes->getAttribute('webspace')) {
            return null;
        }

        /** @var Webspace $webspace */
        return $webspace->getKey();
    }

    private function getLocale(): ?string
    {
        if (!$request = $this->requestStack->getCurrentRequest()) {
            return null;
        }

        return $request->getLocale();
    }
}
