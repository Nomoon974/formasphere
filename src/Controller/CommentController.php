<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class CommentController extends AbstractController
{
    #[Route('/post/{id}/comment', name: 'app_posts_add_comment', methods: ['POST'])]
    public function addComment(
        Posts $post,
        Request $request,
        EntityManagerInterface $entityManager,
        Security $security
    ): JsonResponse {
        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'Unauthorized'], 401);
        }

        $data = json_decode($request->getContent(), true);

        if (empty($data['text']) || strlen(trim($data['text'])) < 1) {
            return new JsonResponse(['error' => 'Le commentaire ne peut pas être vide.'], 400);
        }

        $comment = new Comment();
        $comment->setText($data['text']);
        $comment->setUser($user);
        $comment->setPost($post);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($comment);
        $entityManager->flush();

        return new JsonResponse([
            'id' => $comment->getId(),
            'text' => $comment->getText(),
            'createdAt' => $comment->getCreatedAt()->format('c'),
            'user' => [
                'id' => $user->getId(),
                'avatar' => $user->getAvatar(),
                'fullName' => $user->getFullName(),
            ],
        ]);
    }
}
