<?php

namespace App\Repository;

use App\Entity\Victim;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Victim|null find($id, $lockMode = null, $lockVersion = null)
 * @method Victim|null findOneBy(array $criteria, array $orderBy = null)
 * @method Victim[]    findAll()
 * @method Victim[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VictimRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Victim::class);
    }

    // /**
    //  * @return Victim[] Returns an array of Victim objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Victim
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
