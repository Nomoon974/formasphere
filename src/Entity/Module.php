<?php

namespace App\Entity;

use App\Repository\ModuleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleRepository::class)]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'modules')]
    private ?Program $program = null;

    #[ORM\Column(length: 100)]
    private ?string $module_title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $key_point = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $prerequisities = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): static
    {
        $this->program = $program;

        return $this;
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
}
