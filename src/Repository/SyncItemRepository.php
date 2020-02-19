<?php

namespace App\Repository;

use App\Entity\SyncItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SyncItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SyncItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SyncItem[]    findAll()
 * @method SyncItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyncItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SyncItem::class);
    }

    // /**
    //  * @return SyncItem[] Returns an array of SyncItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SyncItem
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
