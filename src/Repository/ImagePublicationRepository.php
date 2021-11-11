<?php

namespace App\Repository;

use App\Entity\ImagePublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagePublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagePublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagePublication[]    findAll()
 * @method ImagePublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagePublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagePublication::class);
    }

    // /**
    //  * @return ImagePublication[] Returns an array of ImagePublication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagePublication
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
