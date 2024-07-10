<?php

namespace App\Entity;

use App\Repository\UserAccountRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    /**
     * @var Collection<int, Workout>
     */
    #[ORM\OneToMany(targetEntity: Workout::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $workouts;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $gender = null;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'], orphanRemoval:true)]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAccount $userAccount = null;

    #[ORM\Column(nullable: true)]
    private ?int $weight = null;

    #[ORM\Column(nullable: true)]
    private ?int $height = null;

    /**
     * @var Collection<int, BMILog>
     */
    #[ORM\OneToMany(targetEntity: BMILog::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $BMILogs;




    public function __construct()
    {
        $this->workouts = new ArrayCollection();
        $this->BMILogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    /**
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): static
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts->add($workout);
            $workout->setUser($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): static
    {
        if ($this->workouts->removeElement($workout)) {
            if ($workout->getUser() === $this) {
                $workout->setUser(null);
            }
        }

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getUserAccount(): ?UserAccount
    {
        return $this->userAccount;
    }

    public function setUserAccount(UserAccount $userAccount): static
    {
        $this->userAccount = $userAccount;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): static
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return Collection<int, BMILog>
     */
    public function getBMILogs(): Collection
    {
        return $this->BMILogs;
    }

    public function addBMILog(BMILog $bMILog): static
    {
        if (!$this->BMILogs->contains($bMILog)) {
            $this->BMILogs->add($bMILog);
            $bMILog->setUser($this);
        }

        return $this;
    }

    public function removeBMILog(BMILog $bMILog): static
    {
        if ($this->BMILogs->removeElement($bMILog)) {
            // set the owning side to null (unless already changed)
            if ($bMILog->getUser() === $this) {
                $bMILog->setUser(null);
            }
        }

        return $this;
    }

}
