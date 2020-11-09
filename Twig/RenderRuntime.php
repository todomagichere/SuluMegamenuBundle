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

    public function __construct(
        MenuBuilder $builder,
        Environment $twig
    ) {
        $this->builder = $builder;
        $this->twig = $twig;
    }

    public function render(string $resourceKey, string $webspace, string $locale, string $template = null): string
    {
        $items = $this->builder->build($webspace, $resourceKey, $locale);

        return $this->twig->render($template ?? '@SuluMegamenu/section.html.twig', ['items' => $items]);
    }

    public function get(string $resourceKey, string $webspace, string $locale): array
    {
        return $this->builder->build($webspace, $resourceKey, $locale);
    }
}
