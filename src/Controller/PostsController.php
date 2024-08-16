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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
    public function delete(Request $request, Posts $post, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('Vous devez être authentifié pour supprimer un post.');
        }

        //Seul l'admin et le createur du poste peuvent supprimer le poste
        $user = $security->getUser();
        if ($post->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas la permission de supprimer ce post.');
        }
        // Valider le token CSRF
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        } else {
            throw $this->createAccessDeniedException('Token CSRF invalide.');
        }

        return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]);
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

        $post->setText($cleanHtml);

        $entityManager->persist($post);
        $entityManager->flush();

        // Redirigez ou renvoyez une réponse
        return $this->redirectToRoute('space_views', ['id' => $space_id]);
    }

    #[Route('/post/edit/{id}', name: 'app_postEdit')]
    public function editPost(Request $request, Posts $post, EntityManagerInterface $entityManager, Security $security, $id): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        $post = $entityManager->getRepository(Posts::class)->find($id);
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        $user = $security->getUser();
        if ($post->getUser() !== $user && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas la permission de modifier ce post.');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUpdatedAt(new \DateTime());
            $content = $form->get('editContent')->getData(); // ou $request->request->get('editContent') si non géré par un formulaire Symfony
            $purifier = new \HTMLPurifier();
            $cleanHtml = $purifier->purify($content);
            $post->setText($cleanHtml);

            $entityManager->flush();

            return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]); // Assurez-vous de rediriger vers une route valide
        }

        if ($form->isSubmitted()) {
            $this->addFlash('error', 'Le formulaire contient des erreurs. Veuillez vérifier les champs et réessayer.');
        }

        return $this->redirectToRoute('space_views', ['id' => $post->getSpace()->getId()]); // Assurez-vous de rediriger vers une route valide
    }
}
