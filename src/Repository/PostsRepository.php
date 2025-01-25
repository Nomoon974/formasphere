<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Documents;
use App\Entity\Posts;
use App\Entity\Spaces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Posts>
 *
 * @method Posts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posts[]    findAll()
 * @method Posts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posts::class);
    }

    /**
     * @return Posts[]
     */
    public function findBySpace(Spaces $space): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.space = :space')
            ->setParameter('space', $space)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    public function findPostsBySpaceQueryBuilder($space): QueryBuilder
//    {
//        return $this->createQueryBuilder('p')
//            ->where('p.space = :space')
//            ->setParameter('space', $space)
//            ->orderBy('p.created_at', 'DESC');
//    }

    public function findPostsBySpaceQueryBuilder(Spaces $space): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.documents', 'd') // Charge la relation documents
            ->addSelect('d')               // Ajoute les documents dans la requête pour chaque post
            ->where('p.space = :space')
            ->setParameter('space', $space)
            ->orderBy('p.created_at', 'DESC');
    }

    public function findPostWithRelations(Posts $post): array
    {
        $entityManager = $this->getEntityManager();

        // Récupérer les documents associés au post
        $documents = $entityManager->getRepository(Documents::class)->findBy(['post' => $post]);

        // Récupérer les commentaires associés au post
        $comments = $entityManager->getRepository(Comment::class)->findBy(
            ['post' => $post],
            ['created_at' => 'DESC']
        );

        // Retourner toutes les données sous forme d'un tableau
        return [
            'post' => $post,
            'documents' => $documents,
            'comments' => $comments,
        ];
    }


    //    /**
    //     * @return Posts[] Returns an array of Posts objects
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

    //    public function findOneBySomeField($value): ?Posts
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
