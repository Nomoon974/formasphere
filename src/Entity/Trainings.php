<?php

namespace App\Entity;

use App\Repository\TrainingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrainingsRepository::class)]
class Trainings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $training_name = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\OneToMany(mappedBy: 'Training', targetEntity: Report::class)]
    private Collection $reports;

    #[ORM\OneToMany(mappedBy: 'training', targetEntity: Trainee::class)]
    private Collection $trainees;

    public function __construct()
    {
        $this->reports = new ArrayCollection();
        $this->trainees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrainingName(): ?string
    {
        return $this->training_name;
    }

    public function setTrainingName(string $training_name): static
    {
        $this->training_name = $training_name;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(?\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(?\DateTimeInterface $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getReports(): Collection
    {
        return $this->reports;
    }

    public function addReport(Report $report): static
    {
        if (!$this->reports->contains($report)) {
            $this->reports->add($report);
            $report->setTraining($this);
        }

        return $this;
    }

    public function removeReport(Report $report): static
    {
        if ($this->reports->removeElement($report)) {
            // set the owning side to null (unless already changed)
            if ($report->getTraining() === $this) {
                $report->setTraining(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Trainee>
     */
    public function getTrainees(): Collection
    {
        return $this->trainees;
    }

    public function addTrainee(Trainee $trainee): static
    {
        if (!$this->trainees->contains($trainee)) {
            $this->trainees->add($trainee);
            $trainee->setTraining($this);
        }

        return $this;
    }

    public function removeTrainee(Trainee $trainee): static
    {
        if ($this->trainees->removeElement($trainee)) {
            // set the owning side to null (unless already changed)
            if ($trainee->getTraining() === $this) {
                $trainee->setTraining(null);
            }
        }

        return $this;
    }
}
