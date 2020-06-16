<?php

namespace App\Repository;

use App\Entity\HeroLvl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HeroLvl|null find($id, $lockMode = null, $lockVersion = null)
 * @method HeroLvl|null findOneBy(array $criteria, array $orderBy = null)
 * @method HeroLvl[]    findAll()
 * @method HeroLvl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeroLvlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HeroLvl::class);
    }

    // /**
    //  * @return HeroLvl[] Returns an array of HeroLvl objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HeroLvl
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
