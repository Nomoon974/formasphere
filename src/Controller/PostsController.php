<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\Spaces;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/posts')]
class PostsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/', name: 'app_posts_index', methods: ['GET'])]
    public function index(PostsRepository $postsRepository): Response
    {
        return $this->render('posts/index.html.twig', [
            'posts' => $postsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_posts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posts_show', methods: ['GET'])]
    public function show(Posts $post): Response
    {
        return $this->render('posts/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route("/space/{space_id}/post/save", name:"save_post", methods: ['POST'])]
    public function savePost(Request $request, EntityManagerInterface $entityManager, $space_id): Response
    {
        $content = $request->request->get('content');
        $user = $this->security->getUser();

        $space = $this->entityManager->getRepository(Spaces::class)->find($space_id);

        if (!$space) {
            throw $this->createNotFoundException('Aucun espace trouver pour id '.$space_id);
        }

        if (!$this->isGranted('ROLE_TEACHER', $space)) {
            throw $this->createAccessDeniedException('Vous ne possédez pas la permission de poster dans cet espace.');
        }

        $post = new Posts();
        $purifier = new \HTMLPurifier();

        $post->setUser($user);
        $post->setSpace($space);

        $cleanHtml = $purifier->purify($content);

//        if (empty(trim(strip_tags($cleanHtml)))) {
//            $this->addFlash('error', 'Le contenu ne peut pas être vide ou invalide.');
//            return $this->redirectToRoute('space_views', ['id' => $space_id]);
//        }

        $post->setText($cleanHtml);

        $entityManager->persist($post);
        $entityManager->flush();

        // Redirigez ou renvoyez une réponse
        return $this->redirectToRoute('space_views', ['id' => $space_id]);
    }

}
