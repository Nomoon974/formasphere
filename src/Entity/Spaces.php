<?php

namespace App\Entity;

use App\Repository\SpacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpacesRepository::class)]
class Spaces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $space_name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $theme_color = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\OneToMany(mappedBy: 'space', targetEntity: Chats::class)]
    private Collection $chats;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpaceName(): ?string
    {
        return $this->space_name;
    }

    public function setSpaceName(string $space_name): static
    {
        $this->space_name = $space_name;

        return $this;
    }

    public function getThemeColor(): ?string
    {
        return $this->theme_color;
    }

    public function setThemeColor(?string $theme_color): static
    {
        $this->theme_color = $theme_color;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): static
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * @return Collection<int, Chats>
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chats $chat): static
    {
        if (!$this->chats->contains($chat)) {
            $this->chats->add($chat);
            $chat->setSpace($this);
        }

        return $this;
    }

    public function removeChat(Chats $chat): static
    {
        if ($this->chats->removeElement($chat)) {
            // set the owning side to null (unless already changed)
            if ($chat->getSpace() === $this) {
                $chat->setSpace(null);
            }
        }

        return $this;
    }
}
