<?php

namespace App\Repository;

use App\Entity\FurnitureUpgrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FurnitureUpgrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method FurnitureUpgrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method FurnitureUpgrade[]    findAll()
 * @method FurnitureUpgrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FurnitureUpgradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FurnitureUpgrade::class);
    }

    // /**
    //  * @return FurnitureUpgrade[] Returns an array of FurnitureUpgrade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FurnitureUpgrade
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
