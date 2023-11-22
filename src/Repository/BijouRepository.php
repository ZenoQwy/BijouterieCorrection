<?php

namespace App\Repository;

use App\Entity\Bijou;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bijou>
 *
 * @method Bijou|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bijou|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bijou[]    findAll()
 * @method Bijou[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BijouRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bijou::class);
    }

//    /**
//     * @return Bijou[] Returns an array of Bijou objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bijou
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
