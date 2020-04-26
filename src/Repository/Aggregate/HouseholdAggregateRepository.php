<?php

namespace GreenHollow\Pantry\Repository\Aggregate;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\Aggregate\HouseholdAggregate;

/**
 * @method HouseholdAggregate|null find($id, $lockMode = null, $lockVersion = null)
 * @method HouseholdAggregate|null findOneBy(array $criteria, array $orderBy = null)
 * @method HouseholdAggregate[]    findAll()
 * @method HouseholdAggregate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseholdAggregateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HouseholdAggregate::class);
    }
}
