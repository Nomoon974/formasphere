<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $module_title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $key_point = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prerequisities = null;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Spaces::class)]
    private Collection $Spaces;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'modules')]
    private Collection $User;

    public function __construct()
    {
        $this->Spaces = new ArrayCollection();
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModuleTitle(): ?string
    {
        return $this->module_title;
    }

    public function setModuleTitle(string $module_title): static
    {
        $this->module_title = $module_title;

        return $this;
    }

    public function getKeyPoint(): ?string
    {
        return $this->key_point;
    }

    public function setKeyPoint(string $key_point): static
    {
        $this->key_point = $key_point;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrerequisities(): ?string
    {
        return $this->prerequisities;
    }

    public function setPrerequisities(?string $prerequisities): static
    {
        $this->prerequisities = $prerequisities;

        return $this;
    }

    /**
     * @return Collection<int, Spaces>
     */
    public function getSpaces(): Collection
    {
        return $this->Spaces;
    }

    public function addSpace(Spaces $space): static
    {
        if (!$this->Spaces->contains($space)) {
            $this->Spaces->add($space);
            $space->setModule($this);
        }

        return $this;
    }

    public function removeSpace(Spaces $space): static
    {
        if ($this->Spaces->removeElement($space)) {
            // set the owning side to null (unless already changed)
            if ($space->getModule() === $this) {
                $space->setModule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->User->removeElement($user);

        return $this;
    }
}
