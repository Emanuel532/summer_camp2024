<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout implements \ArrayAccess
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



    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'workouts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, ExerciseLog>
     */
    #[ORM\OneToMany(targetEntity: ExerciseLog::class, mappedBy: 'workout', orphanRemoval: true)]
    private Collection $exerciseLogs;

    public function __construct()
    {
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



    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
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
            $exerciseLog->setWorkout($this);
        }

        return $this;
    }

    public function removeExerciseLog(ExerciseLog $exerciseLog): static
    {
        if ($this->exerciseLogs->removeElement($exerciseLog)) {
            // set the owning side to null (unless already changed)
            if ($exerciseLog->getWorkout() === $this) {
                $exerciseLog->setWorkout(null);
            }
        }

        return $this;
    }

    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }
}
