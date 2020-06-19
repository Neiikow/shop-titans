<?php

namespace App\Repository;

use App\Entity\SlotSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlotSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlotSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlotSize[]    findAll()
 * @method SlotSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlotSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlotSize::class);
    }

    // /**
    //  * @return SlotSize[] Returns an array of SlotSize objects
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
    public function findOneBySomeField($value): ?SlotSize
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
