<?php

namespace App\Repository;

use App\Entity\Jour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jour[]    findAll()
 * @method Jour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jour::class);
    }

    public function getNewDates($lastDate){
        return $this->createQueryBuilder('j')
        ->andWhere('j.jour > :val')
        ->setParameter('val', $lastDate)
        ->getQuery()
        ->getResult()
        ;
    }  
      
    //  SELECT * FROM Jour WHERE jour < new \DateTimeImmutable('-1 day')
    public function findPastDates(){
        return $this->createQueryBuilder('d')
        ->andwhere('d.jour < :val')
        ->setParameter('val', new \DateTimeImmutable('-1 day'))
        ->getQuery()
        ->getResult()
        ;
    }

    // /**
    //  * @return Jour[] Returns an array of Jour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Jour
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
