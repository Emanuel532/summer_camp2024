<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nume = null;

    #[ORM\ManyToOne(inversedBy: 'related_workouts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip_id = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'workouts')]
    private Collection $user_id;

    /**
     * @var Collection<int, ExerciseLog>
     */
    #[ORM\OneToMany(targetEntity: ExerciseLog::class, mappedBy: 'workout_id')]
    private Collection $exerciseLogs;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->exerciseLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNume(): ?string
    {
        return $this->nume;
    }

    public function setNume(string $nume): static
    {
        $this->nume = $nume;

        return $this;
    }

    public function getTipId(): ?Tip
    {
        return $this->tip_id;
    }

    public function setTipId(?Tip $tip_id): static
    {
        $this->tip_id = $tip_id;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        $this->user_id->removeElement($userId);

        return $this;
    }

    /**
     * @return Collection<int, ExerciseLog>
     */
    public function getExerciseLogs(): Collection
    {
        return $this->exerciseLogs;
    }

    public function addExerciseLog(ExerciseLog $exerciseLog): static
    {
        if (!$this->exerciseLogs->contains($exerciseLog)) {
            $this->exerciseLogs->add($exerciseLog);
            $exerciseLog->setWorkoutId($this);
        }

        return $this;
    }

    public function removeExerciseLog(ExerciseLog $exerciseLog): static
    {
        if ($this->exerciseLogs->removeElement($exerciseLog)) {
            // set the owning side to null (unless already changed)
            if ($exerciseLog->getWorkoutId() === $this) {
                $exerciseLog->setWorkoutId(null);
            }
        }

        return $this;
    }
}
