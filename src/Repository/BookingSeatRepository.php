<?php

namespace App\Repository;

use App\Entity\BookingSeat;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookingSeat|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingSeat|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingSeat[]    findAll()
 * @method BookingSeat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingSeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingSeat::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BookingSeat $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BookingSeat $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BookingSeat[] Returns an array of BookingSeat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookingSeat
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSeatTravel($id):array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
           "SELECT bs.id
            FROM App\Entity\BookingSeat bs, App\Entity\Booking b
            WHERE bs.booking = b.id
            AND b.lineTrain = :id"
        )->setParameter("id" , $id);

        return $query->getResult();
    }
}
