<?php

namespace App\Repository;

use App\Entity\Spaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

/**
 * @extends ServiceEntityRepository<Spaces>
 *
 * @method Spaces|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spaces|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spaces[]    findAll()
 * @method Spaces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpacesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spaces::class);
    }

    public function findConnectedSpaceForUser(User $user): ?Spaces
    {
        try {
            return $this->createQueryBuilder('s')
                ->join('s.userId', 'u')
                ->where('u = :user')
                ->setParameter('user', $user)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }



//    /**
//     * @return Spaces[] Returns an array of Spaces objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Spaces
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
