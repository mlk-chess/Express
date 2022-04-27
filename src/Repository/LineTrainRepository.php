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


    public function findLineTrainByDate()
    {

        $qb = $this->createQueryBuilder('lt')
            ->select('COUNT(lt) as nb, lt.date_departure')
            ->groupBy('lt.date_departure');

        $query = $qb->getQuery();

        return $query->execute();
    }


    public function findTrainByDate($trainId, $id = null): array
    {
        $entityManager = $this->getEntityManager();


        if ($id) {
            $query = $entityManager->createQuery(
                "SELECT concat(lt.date_departure, ' ', lt.time_departure) AS timestampdeparture,
                concat(lt.date_arrival, ' ', lt.time_arrival) AS timestamparrival,
                t.name
                FROM App\Entity\LineTrain lt , App\Entity\Train t 
                WHERE lt.train = t.id
                AND t.id = :id
                AND lt.id != :idLineTrain"
            )->setParameters(['id' => $trainId, 'idLineTrain' => $id]);
        } else {
            $query = $entityManager->createQuery(
                "SELECT concat(lt.date_departure, ' ', lt.time_departure) AS timestampdeparture,
                concat(lt.date_arrival, ' ', lt.time_arrival) AS timestamparrival,
                t.name
                FROM App\Entity\LineTrain lt , App\Entity\Train t 
                WHERE lt.train = t.id
                AND t.id = :id"
            )->setParameter('id', $trainId);
        }



        return $query->getResult();
    }

    public function findWagonByTrain($trainId): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT w.class, w.type, w.placeNb
            FROM App\Entity\Wagon w
            WHERE w.train = :id"
        )->setParameter('id', $trainId);


        return $query->getResult();
    }


    public function findLineByLineTrain($departure, $arrival): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            "SELECT lt.id
           FROM App\Entity\LineTrain lt , App\Entity\Line l
           WHERE lt.line = l.id
           AND l.name_station_departure = :departure
           AND l.name_station_arrival = :arrival"
        )->setParameters([
            'departure' => $departure,
            'arrival' => $arrival
        ]);


        return $query->getResult();
    }


    // public function findLineByDate(): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //        "SELECT concat(lt.date_departure, ' ', lt.time_departure) AS timestampdeparture,
    //        concat(lt.date_arrival, ' ', lt.time_arrival) AS timestamparrival,
    //        t.name
    //        FROM App\Entity\LineTrain lt , App\Entity\Train t 
    //        WHERE lt.train = t.id
    //        AND t.id = :id"
    //     )->setParameter('id', $trainId);


    //     return $query->getResult();
    // }

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
