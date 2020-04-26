<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServicePantryItem;

/**
 * @method ServicePantryItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicePantryItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicePantryItem[]    findAll()
 * @method ServicePantryItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicePantryItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicePantryItem::class);
    }
}
