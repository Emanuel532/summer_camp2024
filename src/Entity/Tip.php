<?php

namespace App\Entity;

use App\Repository\TipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipRepository::class)]
class Tip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nume = null;

    /**
     * @var Collection<int, Workout>
     */
    #[ORM\OneToMany(targetEntity: Workout::class, mappedBy: 'tip_id')]
    private Collection $related_workouts;

    /**
     * @var Collection<int, Exercitii>
     */
    #[ORM\OneToMany(targetEntity: Exercitii::class, mappedBy: 'tip_id')]
    private Collection $exercitiis;

    public function __construct()
    {
        $this->related_workouts = new ArrayCollection();
        $this->exercitiis = new ArrayCollection();
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

    /**
     * @return Collection<int, Workout>
     */
    public function getRelatedWorkouts(): Collection
    {
        return $this->related_workouts;
    }

    public function addRelatedWorkout(Workout $relatedWorkout): static
    {
        if (!$this->related_workouts->contains($relatedWorkout)) {
            $this->related_workouts->add($relatedWorkout);
            $relatedWorkout->setTipId($this);
        }

        return $this;
    }

    public function removeRelatedWorkout(Workout $relatedWorkout): static
    {
        if ($this->related_workouts->removeElement($relatedWorkout)) {
            // set the owning side to null (unless already changed)
            if ($relatedWorkout->getTipId() === $this) {
                $relatedWorkout->setTipId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exercitii>
     */
    public function getExercitiis(): Collection
    {
        return $this->exercitiis;
    }

    public function addExercitii(Exercitii $exercitii): static
    {
        if (!$this->exercitiis->contains($exercitii)) {
            $this->exercitiis->add($exercitii);
            $exercitii->setTipId($this);
        }

        return $this;
    }

    public function removeExercitii(Exercitii $exercitii): static
    {
        if ($this->exercitiis->removeElement($exercitii)) {
            // set the owning side to null (unless already changed)
            if ($exercitii->getTipId() === $this) {
                $exercitii->setTipId(null);
            }
        }

        return $this;
    }
}
