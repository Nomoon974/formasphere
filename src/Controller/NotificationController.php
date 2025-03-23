<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use App\Service\MercureJwtProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/api/notifications', name: 'api_notifications', methods: ['GET'])]
    public function getNotifications(NotificationRepository $repo, Security $security): JsonResponse
    {
        $user = $security->getUser();
        $notifications = $repo->findBy(['user' => $user]);

        $data = array_map(function ($notification) use ($user) {
            return [
                'id' => $notification->getId(),
                'user' => $notification->getUser()->getFullName(),
                'body' => $notification->getBody(),
                'notificationType' => $notification->getNotificationType(),
                'associatedLink' => $notification->getAssociatedLink(),
                'notificationDate' => $notification->getNotificationDate(),
                'isRead' => $notification->getIsRead(),
            ];
        }, $notifications);

        return $this->json($data, 200, [], ['groups' => ['notification_read']]);
    }

    #[Route('/api/notifications/read/{id}', name: 'read_notification', methods: ['POST'])]
    public function markAsRead(Notification $notification, EntityManagerInterface $entityManager, Security $security): JsonResponse
    {
//        dd($_ENV['MERCURE_JWT_SECRET']);


        $user = $security->getUser();
        if ($notification->getUser() !== $user) {
            return $this->json(['error' => 'Unauthorized'], 403);
        }

        $notification->setIsRead(true);
        $entityManager->persist($notification);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }

    #[Route('/api/token/{type}/{id}', name: 'api_token')]
    public function token(string $type, int $id, MercureJwtProvider $jwtProvider) : JsonResponse
    {
        if ($type === 'space') {
            $topic = "space/{$id}";
        } elseif ($type === 'notifications') {
            $topic = "notifications/{$id}";
        } else {
            throw new \InvalidArgumentException('Type invalide.');
        }

        $token = $jwtProvider->createSubscriberToken(["*"]);


        // Crée le cookie 'mercureAuthorization'
        $cookie = Cookie::create(
            'mercureAuthorization',  // nom du cookie
            $token,                  // valeur (ton token JWT)
            0,                       // expire à 0 signifie session cookie
            '/',                     // chemin
            null,                    // domaine (null pour le domaine courant)
            false,                   // secure (false, car en HTTP)
            false,                   // httpOnly (selon ton besoin, false si accessible par JS)
            false,                   // raw
            'Lax'                    // SameSite (Lax pour HTTP)
        );

        $response = new JsonResponse(['token' => $token]);
        $response->headers->setCookie($cookie);
        return $response;
    }

}