<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServicePantry;

/**
 * @method ServicePantry|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServicePantry|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServicePantry[]    findAll()
 * @method ServicePantry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicePantryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServicePantry::class);
    }
}
