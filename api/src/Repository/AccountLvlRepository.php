<?php

namespace App\Repository;

use App\Entity\AccountLvl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccountLvl|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountLvl|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountLvl[]    findAll()
 * @method AccountLvl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountLvlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountLvl::class);
    }

    // /**
    //  * @return AccountLvl[] Returns an array of AccountLvl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AccountLvl
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
