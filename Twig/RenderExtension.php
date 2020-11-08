<?php

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RenderExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('sulu_megamenu_render', [RenderRuntime::class, 'render']),
            new TwigFunction('sulu_megamenu_get', [RenderRuntime::class, 'get']),
        ];
    }
}
