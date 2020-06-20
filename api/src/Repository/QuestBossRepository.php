<?php

namespace App\Repository;

use App\Entity\QuestBoss;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestBoss|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestBoss|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestBoss[]    findAll()
 * @method QuestBoss[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestBossRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestBoss::class);
    }

    // /**
    //  * @return QuestBoss[] Returns an array of QuestBoss objects
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
    public function findOneBySomeField($value): ?QuestBoss
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
