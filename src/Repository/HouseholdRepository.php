<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\Household;

/**
 * @method Household|null find($id, $lockMode = null, $lockVersion = null)
 * @method Household|null findOneBy(array $criteria, array $orderBy = null)
 * @method Household[]    findAll()
 * @method Household[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseholdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Household::class);
    }
}
