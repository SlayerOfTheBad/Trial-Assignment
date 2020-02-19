<?php

namespace App\Repository;

use App\Entity\SyncBag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SyncBag|null find($id, $lockMode = null, $lockVersion = null)
 * @method SyncBag|null findOneBy(array $criteria, array $orderBy = null)
 * @method SyncBag[]    findAll()
 * @method SyncBag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SyncBagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SyncBag::class);
    }

    // /**
    //  * @return SyncBag[] Returns an array of SyncBag objects
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
    public function findOneBySomeField($value): ?SyncBag
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
