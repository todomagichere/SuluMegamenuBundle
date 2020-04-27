<?php

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
