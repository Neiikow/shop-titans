<?php

namespace App\Repository;

use App\Entity\BuildingLvl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingLvl|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingLvl|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingLvl[]    findAll()
 * @method BuildingLvl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingLvlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingLvl::class);
    }

    // /**
    //  * @return BuildingLvl[] Returns an array of BuildingLvl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BuildingLvl
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
