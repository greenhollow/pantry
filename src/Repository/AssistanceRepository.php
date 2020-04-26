<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\Assistance;

/**
 * @method Assistance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assistance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assistance[]    findAll()
 * @method Assistance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssistanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assistance::class);
    }
}
