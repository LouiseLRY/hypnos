<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Booking $entity, bool $flush = true): void
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
    public function remove(Booking $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */

    public function findByVacancy($dateStart, $dateEnd, $suite)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.dateStart BETWEEN :dateStart AND :dateEnd')
            ->orWhere('b.dateEnd BETWEEN :dateStart AND :dateEnd')
            ->orWhere('b.dateStart <= :dateStart AND b.dateEnd >= :dateEnd')
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->andWhere('b.suite = :suite')
            ->setParameter('suite', $suite)
            ->getQuery()
            ->getResult();
    }


    public function findByUser($user)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.custommer = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
