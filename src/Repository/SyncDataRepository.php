<?php

namespace App\Repository;

use App\Entity\SyncData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SyncData|null find($id, $lockMode = null, $lockVersion = null)
 * @method SyncData|null findOneBy(array $criteria, array $orderBy = null)
 * @method SyncData[]    findAll()
 * @method SyncData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyncDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SyncData::class);
    }

    // /**
    //  * @return SyncData[] Returns an array of SyncData objects
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
    public function findOneBySomeField($value): ?SyncData
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
