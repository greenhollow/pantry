<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServiceAssistanceStatus;

/**
 * @method ServiceAssistanceStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAssistanceStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAssistanceStatus[]    findAll()
 * @method ServiceAssistanceStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAssistanceStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAssistanceStatus::class);
    }
}
