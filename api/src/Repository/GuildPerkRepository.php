<?php

namespace App\Repository;

use App\Entity\GuildPerk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GuildPerk|null find($id, $lockMode = null, $lockVersion = null)
 * @method GuildPerk|null findOneBy(array $criteria, array $orderBy = null)
 * @method GuildPerk[]    findAll()
 * @method GuildPerk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuildPerkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GuildPerk::class);
    }

    // /**
    //  * @return GuildPerk[] Returns an array of GuildPerk objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GuildPerk
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
