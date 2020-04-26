<?php

namespace GreenHollow\Pantry\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use GreenHollow\Pantry\Entity\AssistanceItem;

/**
 * @method AssistanceItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssistanceItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssistanceItem[]    findAll()
 * @method AssistanceItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssistanceItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssistanceItem::class);
    }
}
