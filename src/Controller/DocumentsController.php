<?php

namespace App\Controller;

use App\Entity\Documents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DocumentsController extends AbstractController
{
    #[Route('/documents/{id}/delete', name: 'app_documents_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        CsrfTokenManagerInterface $csrfTokenManager
    ): JsonResponse {

        $document = $entityManager->getRepository(Documents::class)->find($id);

        if (!$document) {
            return new JsonResponse(['error' => 'Fichier introuvable.'], Response::HTTP_NOT_FOUND);
        }

        // Vérifie que l'utilisateur est le propriétaire du fichier
        if ($document->getPost()->getUser() !== $this->getUser() || !$this->isGranted('ROLE_ADMIN')) {
            return new JsonResponse(['error' => 'Vous n\'êtes pas autorisé à supprimer ce fichier.'], Response::HTTP_FORBIDDEN);
        }

        $submittedToken = json_decode($request->getContent(), true)['_token'] ?? '';
        $csrfToken = new CsrfToken('delete_document' . $document->getId(), $submittedToken);

        if (!$csrfTokenManager->isTokenValid($csrfToken)) {
            return new JsonResponse(['error' => 'Jeton CSRF invalide.'], Response::HTTP_FORBIDDEN);
        }

        // Supprime le fichier du disque
        $documentsPath = $this->getParameter('uploads_directory') . '/' . $document->getLink();
        if (file_exists($documentsPath)) {
            unlink($documentsPath);
        }

        // Supprime l'entrée de la base de données
        $entityManager->remove($document);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Fichier supprimé avec succès.'], Response::HTTP_OK);
    }


}
