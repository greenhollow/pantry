<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServicePantryStatus;

/**
 * @method ServicePantryStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicePantryStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicePantryStatus[]    findAll()
 * @method ServicePantryStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicePantryStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicePantryStatus::class);
    }
}
