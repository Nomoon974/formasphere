<?php

namespace App\Controller;

use App\Entity\Spaces;
use App\Form\SpacesType;
use App\Repository\SpacesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spaces')]
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

    #[Route('/{id}', name: 'app_spaces_show', methods: ['GET'])]
    public function show(Spaces $space): Response
    {
        return $this->render('spaces/show.html.twig', [
            'space' => $space,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spaces_edit', methods: ['GET', 'POST'])]
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
    public function delete(Request $request, Spaces $space, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$space->getId(), $request->request->get('_token'))) {
            $entityManager->remove($space);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spaces_index', [], Response::HTTP_SEE_OTHER);
    }
}
