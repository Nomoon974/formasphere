<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $body = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    private ?string $notification_type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $notification_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $associated_link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getNotificationType(): ?string
    {
        return $this->notification_type;
    }

    public function setNotificationType(string $notification_type): static
    {
        $this->notification_type = $notification_type;

        return $this;
    }

    public function getNotificationDate(): ?\DateTimeInterface
    {
        return $this->notification_date;
    }

    public function setNotificationDate(\DateTimeInterface $notification_date): static
    {
        $this->notification_date = $notification_date;

        return $this;
    }

    public function getAssociatedLink(): ?string
    {
        return $this->associated_link;
    }

    public function setAssociatedLink(?string $associated_link): static
    {
        $this->associated_link = $associated_link;

        return $this;
    }
}
