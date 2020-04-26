<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\PantryItem;

/**
 * @method PantryItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method PantryItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method PantryItem[]    findAll()
 * @method PantryItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PantryItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PantryItem::class);
    }
}
