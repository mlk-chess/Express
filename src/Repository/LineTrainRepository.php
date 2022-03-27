<?php

namespace App\Repository;

use App\Entity\LineTrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LineTrain|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineTrain|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineTrain[]    findAll()
 * @method LineTrain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineTrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineTrain::class);
    }


    public function findTrainByDate($trainId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
           "SELECT concat(lt.date_departure, ' ', lt.time_departure) AS timestampdeparture,
           concat(lt.date_arrival, ' ', lt.time_arrival) AS timestamparrival,
           t.name
           FROM App\Entity\LineTrain lt , App\Entity\Train t 
           WHERE lt.train = t.id
           AND t.id = :id"
        )->setParameter('id', $trainId);

       
        return $query->getResult();
    }

    // /**
    //  * @return LineTrain[] Returns an array of LineTrain objects
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
    public function findOneBySomeField($value): ?LineTrain
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
