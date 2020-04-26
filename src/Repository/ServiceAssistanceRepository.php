<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServiceAssistance;

/**
 * @method ServiceAssistance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAssistance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAssistance[]    findAll()
 * @method ServiceAssistance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAssistanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAssistance::class);
    }
}
