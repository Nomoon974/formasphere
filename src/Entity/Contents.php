<?php

namespace App\Entity;

use App\Repository\ContentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentsRepository::class)]
class Contents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $content_type = null;

    #[ORM\Column(length: 255)]
    private ?string $content_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $publication_date = null;

    #[ORM\OneToMany(mappedBy: 'content_id', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToOne(targetEntity: Spaces::class, inversedBy: "contents")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Spaces $space = null;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    private ?Posts $post = null;

    public function __construct()
    {
        $this->publication_date = new \DateTime();
        $this->comments = new ArrayCollection();
    }

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

    public function getContentType(): ?string
    {
        return $this->content_type;
    }

    public function setContentType(string $content_type): static
    {
        $this->content_type = $content_type;

        return $this;
    }

    public function getContentLink(): ?string
    {
        return $this->content_link;
    }

    public function setContentLink(string $content_link): static
    {
        $this->content_link = $content_link;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setContentId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getContentId() === $this) {
                $comment->setContentId(null);
            }
        }

        return $this;
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

    public function getPost(): ?Posts
    {
        return $this->post;
    }

    public function setPost(?Posts $post): static
    {
        $this->post = $post;

        return $this;
    }

}
