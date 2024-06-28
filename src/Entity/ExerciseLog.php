<?php

namespace App\Entity;

use App\Repository\ExerciseLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseLogRepository::class)]
class ExerciseLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'exerciseLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workout $workout_id = null;

    #[ORM\Column]
    private ?int $nr_reps = null;

    #[ORM\Column]
    private ?int $durata = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkoutId(): ?Workout
    {
        return $this->workout_id;
    }

    public function setWorkoutId(?Workout $workout_id): static
    {
        $this->workout_id = $workout_id;

        return $this;
    }

    public function getNrReps(): ?int
    {
        return $this->nr_reps;
    }

    public function setNrReps(int $nr_reps): static
    {
        $this->nr_reps = $nr_reps;

        return $this;
    }

    public function getDurata(): ?int
    {
        return $this->durata;
    }

    public function setDurata(int $durata): static
    {
        $this->durata = $durata;

        return $this;
    }
}
