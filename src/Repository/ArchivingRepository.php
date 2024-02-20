<?php

namespace App\Repository;

use App\Entity\Archiving;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Archiving>
 *
 * @method Archiving|null find($id, $lockMode = null, $lockVersion = null)
 * @method Archiving|null findOneBy(array $criteria, array $orderBy = null)
 * @method Archiving[]    findAll()
 * @method Archiving[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchivingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Archiving::class);
    }

//    /**
//     * @return Archiving[] Returns an array of Archiving objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Archiving
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
