<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServiceAssistanceHistory;

/**
 * @method ServiceAssistanceHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAssistanceHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAssistanceHistory[]    findAll()
 * @method ServiceAssistanceHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAssistanceHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAssistanceHistory::class);
    }
}
