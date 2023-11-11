<?php

namespace App\Repository;

use App\Entity\LnList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LnList>
 *
 * @method LnList|null find($id, $lockMode = null, $lockVersion = null)
 * @method LnList|null findOneBy(array $criteria, array $orderBy = null)
 * @method LnList[]    findAll()
 * @method LnList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LnListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LnList::class);
    }

//    /**
//     * @return LnList[] Returns an array of LnList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LnList
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
