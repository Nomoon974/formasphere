<?php

// src/Controller/PasswordController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

class PasswordController extends AbstractController
{
    #[Route("/password/change", name: "app_change_password", methods: ['GET', 'POST'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();  // Assure-toi que l'utilisateur est connecté
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();

            // Vérifier l'ancien mot de passe
            if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
                $form->get('oldPassword')->addError(new FormError('The current password is incorrect.'));
                return $this->render('security/change_password.html.twig', [
                    'form' => $form->createView()
                ]);
            }

            // Hasher le nouveau mot de passe et le définir pour l'utilisateur
            $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
            $entityManager->flush();

            $this->addFlash('success', 'Your password has been changed successfully.');
            return $this->redirectToRoute('app_logout');
        }

        return $this->render('security/change_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

