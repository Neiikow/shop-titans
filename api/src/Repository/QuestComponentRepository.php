<?php

namespace App\Repository;

use App\Entity\QuestComponent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestComponent|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestComponent|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestComponent[]    findAll()
 * @method QuestComponent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestComponentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestComponent::class);
    }

    // /**
    //  * @return QuestComponent[] Returns an array of QuestComponent objects
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
    public function findOneBySomeField($value): ?QuestComponent
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
