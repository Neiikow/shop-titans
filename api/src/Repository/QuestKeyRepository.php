<?php

namespace App\Repository;

use App\Entity\QuestKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestKey[]    findAll()
 * @method QuestKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestKey::class);
    }

    // /**
    //  * @return QuestKey[] Returns an array of QuestKey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestKey
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
