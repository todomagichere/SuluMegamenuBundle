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

namespace TheCocktail\Bundle\MegaMenuBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Pablo Lozano <lozanomunarriz@gmail.com>
 */
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
