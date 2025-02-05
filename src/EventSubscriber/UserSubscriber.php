<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Environment;
use App\Service\UserDataProvider;

class UserSubscriber implements EventSubscriberInterface
{
    public function __construct(ReadOnly Security $security,ReadOnly Environment $twig, ReadOnly UserDataProvider $userDataProvider)
    {

    }

    public function onKernelController(ControllerEvent $event): void
    {
        $user = $this->security->getUser();
        $userData = $user ? UserDataProvider::serializeUserData($user) : null;
        $this->twig->addGlobal('userData_json', $userData);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
