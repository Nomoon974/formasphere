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

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'spaces')]
    private Collection $userId;

    #[ORM\OneToMany(mappedBy: "space", targetEntity: Archiving::class)]
    private Collection $archivings;

    #[ORM\OneToMany(targetEntity: Documents::class, mappedBy: "space")]
    private Collection $documents;

    #[ORM\OneToMany(targetEntity: Contents::class, mappedBy: "space")]
    private Collection $contents;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $space_img = null;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
        $this->userId = new ArrayCollection();
        $this->archivings = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->contents = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->userId->removeElement($userId);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getArchivings(): Collection
    {
        return $this->archivings;
    }

    /**
     * @param Collection $archivings
     */
    public function setArchivings(Collection $archivings): void
    {
        $this->archivings = $archivings;
    }

    public function addArchiving(Archiving $archiving): self
    {
        if (!$this->archivings->contains($archiving)) {
            $this->archivings[] = $archiving;
            $archiving->setSpace($this);
        }

        return $this;
    }

    public function removeArchiving(Archiving $archiving): self
    {
        if ($this->archivings->removeElement($archiving)) {
            // set the owning side to null (unless already changed)
            if ($archiving->getSpace() === $this) {
                $archiving->setSpace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    /**
     * @param Collection $documents
     */
    public function setDocuments(Collection $documents): void
    {
        $this->documents = $documents;
    }

    public function addDocument(Documents $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setSpace($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getSpace() === $this) {
                $document->setSpace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    /**
     * @param Collection $contents
     */
    public function setContents(Collection $contents): void
    {
        $this->contents = $contents;
    }

    public function addContent(Contents $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->setSpace($this);
        }

        return $this;
    }

    public function removeContent(Contents $content): self
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getSpace() === $this) {
                $content->setSpace(null);
            }
        }

        return $this;
    }

    public function getSpaceImg(): ?string
    {
        return $this->space_img;
    }

    public function setSpaceImg(?string $space_img): static
    {
        $this->space_img = $space_img;

        return $this;
    }

}
