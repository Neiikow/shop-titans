<?php

namespace App\Repository;

use App\Entity\ShopExpansion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShopExpansion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopExpansion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopExpansion[]    findAll()
 * @method ShopExpansion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopExpansionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopExpansion::class);
    }

    // /**
    //  * @return ShopExpansion[] Returns an array of ShopExpansion objects
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
    public function findOneBySomeField($value): ?ShopExpansion
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
