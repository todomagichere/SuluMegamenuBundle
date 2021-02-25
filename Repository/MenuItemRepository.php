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

namespace TheCocktail\Bundle\MegaMenuBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use TheCocktail\Bundle\MegaMenuBundle\Entity\MenuItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method MenuItem|null find($id, $lockMode = null, $lockVersion = null)
 *
 * @author Pablo Lozano <lozanomunarriz@gmail.com>
 */
class MenuItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuItem::class);
    }

    public function save(MenuItem $item): void
    {
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();
    }

    public function remove(int $id): void
    {
        if ($entity = $this->find($id)) {
            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }
}
