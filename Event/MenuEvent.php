<?php

/**
 * This file is part of Sulu Megamenu Bundle.
 *
 * (c) The Cocktail Expericence S.L.
 *
 *  This source file is subject to the MIT license that is bundled
 *  with this source code in the file LICENSE.
 */

namespace TheCocktail\Bundle\MegaMenuBundle\Event;

use TheCocktail\Bundle\MegaMenuBundle\Entity\MenuItem;

class MenuEvent
{
    const PUBLISHED = 'sulu_megamenu.published';
    const UNPUBLISHED = 'sulu_megamenu.unpublished';
    const REMOVED = 'sulu_megamenu.removed';

    private MenuItem $item;

    public function __construct(MenuItem $item)
    {
        $this->item = $item;
    }

    public function getItem(): MenuItem
    {
        return $this->item;
    }
}
