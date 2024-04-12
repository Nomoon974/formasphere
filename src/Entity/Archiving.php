<?php

namespace App\Entity;

use App\Repository\ArchivingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchivingRepository::class)]
class Archiving
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Spaces::class , inversedBy: 'archivings')]
    private ?Spaces $space = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $archiving_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reason = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletion_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Spaces|null
     */
    public function getSpace(): ?Spaces
    {
        return $this->space;
    }

    /**
     * @param Spaces|null $space
     */
    public function setSpace(?Spaces $space): void
    {
        $this->space = $space;
    }



    public function getArchivingDate(): ?\DateTimeInterface
    {
        return $this->archiving_date;
    }

    public function setArchivingDate(\DateTimeInterface $archiving_date): static
    {
        $this->archiving_date = $archiving_date;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getDeletionDate(): ?\DateTimeInterface
    {
        return $this->deletion_date;
    }

    public function setDeletionDate(?\DateTimeInterface $deletion_date): static
    {
        $this->deletion_date = $deletion_date;

        return $this;
    }

}
