<?php

namespace App\Repository;

use App\Entity\Typeprojet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typeprojet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typeprojet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typeprojet[]    findAll()
 * @method Typeprojet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeprojetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typeprojet::class);
    }

    // /**
    //  * @return Typeprojet[] Returns an array of Typeprojet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Typeprojet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
