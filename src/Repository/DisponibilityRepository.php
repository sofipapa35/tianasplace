<?php

namespace App\Repository;

use DateTime;
use App\Entity\Disponibility;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Disponibility|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disponibility|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disponibility[]    findAll()
 * @method Disponibility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DisponibilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disponibility::class);
    }
    
    // DisponibilityRepository
    //  SELECT * FROM Disponibility WHERE jour_id = $jourId AND count > 0 GROUP BY personnes_id
    public function getDatePeople($jourId){
        return $this->createQueryBuilder('d')
        ->andWhere('d.jour = :val')
        ->andWhere('d.count > :val2')
        ->setParameter('val', $jourId)
        ->setParameter('val2', 0)
        ->groupBy('d.personnes')
        ->getQuery()
        ->getResult()
        ;
    }

    // DisponibilityRepository
    //  SELECT * FROM Disponibility WHERE personnes_id = $peopleId AND jour_id = $jourId AND count > 0 GROUP BY heure_id
    public function getDayPeopleTime($jourId, $peopleId){
        return $this->createQueryBuilder('d')
        ->andwhere('d.personnes = :val')
        ->andWhere('d.jour = :val2')
        ->andWhere('d.count > :dispo')
        ->setParameter('val', $peopleId)
        ->setParameter('val2', $jourId)
        ->setParameter('dispo', 0)
        ->groupBy('d.heure')
        ->getQuery()
        ->getResult()
        ;
    }

    // /**
    //  * @return Disponibility[] Returns an array of Disponibility objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Disponibility
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
