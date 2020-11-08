<?php

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\Twig;

use TheCocktail\Bundle\MegaMenuBundle\Builder\MenuBuilder;
use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

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
