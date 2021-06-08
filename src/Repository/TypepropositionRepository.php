<?php

namespace App\Repository;

use App\Entity\Typeproposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Typeproposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Typeproposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Typeproposition[]    findAll()
 * @method Typeproposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypepropositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Typeproposition::class);
    }

    // /**
    //  * @return Typeproposition[] Returns an array of Typeproposition objects
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
    public function findOneBySomeField($value): ?Typeproposition
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
