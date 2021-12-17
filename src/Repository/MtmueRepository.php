<?php

namespace App\Repository;

use App\Entity\Mtmue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mtmue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mtmue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mtmue[]    findAll()
 * @method Mtmue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MtmueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mtmue::class);
    }

    // /**
    //  * @return Mtmue[] Returns an array of Mtmue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mtmue
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
