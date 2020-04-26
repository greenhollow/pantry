<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\ServiceAssistanceItem;

/**
 * @method ServiceAssistanceItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceAssistanceItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceAssistanceItem[]    findAll()
 * @method ServiceAssistanceItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceAssistanceItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceAssistanceItem::class);
    }
}
