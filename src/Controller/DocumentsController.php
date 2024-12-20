<?php

namespace App\Controller;

use App\Entity\Documents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DocumentsController extends AbstractController
{
    #[Route('/documents/{id}/delete', name: 'app_documents_delete', methods: ['POST'])]
    public function delete(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager
    ): Response {
        $documents = $entityManager->getRepository(Documents::class)->find($id);

        // Vérifie que le fichier existe
        if (!$documents) {
            $this->addFlash('error', 'Fichier introuvable.');
            return $this->redirectToRoute('app_posts_show', ['id' => $documents->getPost()->getId()]);
        }

        // Vérifie que l'utilisateur est le propriétaire du fichier
        if ($documents->getPost()->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'Vous n\'êtes pas autorisé à supprimer ce fichier.');
            return $this->redirectToRoute('app_posts_show', ['id' => $documents->getPost()->getId()]);
        }

        $submittedToken = $request->request->get('_token');
        $csrfToken = new CsrfToken('delete_document' . $documents->getId(), $submittedToken);

        // Vérifie le jeton CSRF
        if (!$csrfTokenManager->isTokenValid($csrfToken)) {
            $this->addFlash('error', 'Jeton CSRF invalide.');
            return $this->redirectToRoute('app_posts_show', ['id' => $documents->getPost()->getId()]);
        }

        // Supprime le fichier du disque
        $documentsPath = $this->getParameter('uploads_directory') . '/' . $documents->getLink();
        if (file_exists($documentsPath)) {
            unlink($documentsPath);
        }

        // Supprime le fichier de la base de données
        $entityManager->remove($documents);
        $entityManager->flush();

        $this->addFlash('success', 'Fichier supprimé avec succès.');
        return $this->redirectToRoute('app_posts_show', ['id' => $documents->getPost()->getId()]);
    }

}
