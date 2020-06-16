<?php

namespace App\Repository;

use App\Entity\BuildingTick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BuildingTick|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingTick|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingTick[]    findAll()
 * @method BuildingTick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingTickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BuildingTick::class);
    }

    // /**
    //  * @return BuildingTick[] Returns an array of BuildingTick objects
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
    public function findOneBySomeField($value): ?BuildingTick
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
