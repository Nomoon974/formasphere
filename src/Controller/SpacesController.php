<?php

namespace App\Controller;


use App\Entity\Spaces;
use App\Form\PostsType;
use App\Form\SpacesType;
use App\Repository\PostsRepository;
use App\Repository\SpacesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


class SpacesController extends AbstractController
{
    #[Route('/', name: 'app_spaces_index', methods: ['GET'])]
    public function index(SpacesRepository $spacesRepository): Response
    {
        return $this->render('spaces/index.html.twig', [
            'spaces' => $spacesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spaces_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $space = new Spaces();
        $form = $this->createForm(SpacesType::class, $space);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($space);
            $entityManager->flush();

            return $this->redirectToRoute('app_spaces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spaces/new.html.twig', [
            'space' => $space,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_spaces_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Spaces $space, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpacesType::class, $space);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spaces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spaces/edit.html.twig', [
            'space' => $space,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spaces_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Spaces $space, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$space->getId(), $request->request->get('_token'))) {
            $entityManager->remove($space);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spaces_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/space/{id}', name: 'space_views')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function view(
        Spaces $space,
        Security $security,
        PaginatorInterface $paginator,
        Request $request,
        PostsRepository $postsRepository,
        CacheInterface $cache
    ): Response {

        $page = $request->query->getInt('page', 1);
        $cacheKey = sprintf('space_%d_page_%d_posts', $space->getId(), $page);

        $posts = $cache->get($cacheKey, function (ItemInterface $item) use ($postsRepository, $space) {
            $item->expiresAfter(12000);
            $queryBuilder = $postsRepository->findPostsBySpaceQueryBuilder($space);
            return $queryBuilder->getQuery()->getResult();
        });

        $pagination = $paginator->paginate(
            $posts,
            $page,
            15
        );

        // Création des formulaires d'édition pour chaque post
        $editForms = [];
        foreach ($pagination as $post) {
            $form = $this->createForm(PostsType::class, $post);
            $editForms[$post->getId()] = $form->createView();
        }

        $cache->delete(sprintf('space_%d_page_%d_posts', $space->getId(), 1));

        return $this->render('spaces/space_view.html.twig', [
            'space' => $space,
            'user' => $security->getUser(),
            'pagination' => $pagination,
            'editForms' => $editForms,
        ]);
    }

}
