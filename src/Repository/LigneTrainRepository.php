<?php

namespace App\Repository;

use App\Entity\LigneTrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LigneTrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneTrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneTrain[]    findAll()
 * @method LigneTrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneTrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneTrain::class);
    }

    // /**
    //  * @return LigneTrain[] Returns an array of LigneTrain objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LigneTrain
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
