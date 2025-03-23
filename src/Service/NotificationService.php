<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NotificationService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private HubInterface $hub,
        private urlGeneratorInterface $urlGenerator
    ) {}

    public function sendNotification(User $user, string $topic, string $message, string $routeName, array $routeParams = [], string $type = "info")
    {

        $link = $this->urlGenerator->generate($routeName, $routeParams, UrlGeneratorInterface::ABSOLUTE_URL);

        // Enregistrer en base
        $notif = new Notification();
        $notif->setUser($user);
        $notif->setBody($message);
        $notif->setNotificationType($type);
        $notif->setAssociatedLink($link);
        $notif->setNotificationDate(new \DateTime());
        $notif->setIsRead(false);

        $this->entityManager->persist($notif);
        $this->entityManager->flush();

        // Diffusion en temps réel via Mercure
        $update = new Update(
        // Le topic unique pour cet user
            $topic,
            json_encode([
                'id' => $notif->getId(),
                'message' => $message,
                'link' => $link,
                'type' => $type,
            ])
        );

        $this->hub->publish($update);
    }
}
