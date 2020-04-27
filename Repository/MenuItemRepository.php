<?php

declare(strict_types=1);

namespace TheCocktail\Bundle\MegaMenuBundle\Repository;

use TheCocktail\Bundle\MegaMenuBundle\Entity\MenuItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MenuItem|null find($id, $lockMode = null, $lockVersion = null)
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
