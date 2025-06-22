<?php

namespace App\Repository;

use App\Entity\Pizza;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pizza>
 */
class PizzaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pizza::class);
    }

    public function orderByName($order): array
   {

       return $this->createQueryBuilder('p')
           ->orderBy('p.nom', $order)
           ->getQuery()
           ->getResult()
       ;
   }

//    /**
//     * @return Pizza[] Returns an array of Pizza objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pizza
//    {
//        return $this->createQueryBuilder('p')
//             ->leftJoin('p.pate','pa')
//            ->andWhere('pa.label = :pikachu')
//            ->setParameter('pikachu', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
