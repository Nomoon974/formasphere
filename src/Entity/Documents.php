<?php

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentsRepository::class)]
class Documents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 50)]
    private ?string $link = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\OneToMany(mappedBy: 'document', targetEntity: Archiving::class)]
    private Collection $archivings;

    public function __construct()
    {
        $this->archivings = new ArrayCollection();
        $this->timestamp = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return Collection<int, Archiving>
     */
    public function getArchivings(): Collection
    {
        return $this->archivings;
    }

    public function addArchiving(Archiving $archiving): static
    {
        if (!$this->archivings->contains($archiving)) {
            $this->archivings->add($archiving);
            $archiving->setDocument($this);
        }

        return $this;
    }

    public function removeArchiving(Archiving $archiving): static
    {
        if ($this->archivings->removeElement($archiving)) {
            // set the owning side to null (unless already changed)
            if ($archiving->getDocument() === $this) {
                $archiving->setDocument(null);
            }
        }

        return $this;
    }
}
