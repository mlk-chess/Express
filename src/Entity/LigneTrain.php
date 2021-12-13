<?php

namespace App\Entity;

use App\Repository\LigneTrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneTrainRepository::class)
 */
class LigneTrain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $horaireA;

    /**
     * @ORM\Column(type="time")
     */
    private $horaireD;

    /**
     * @ORM\OneToMany(targetEntity=Train::class, mappedBy="ligneTrain")
     */
    private $train;

    /**
     * @ORM\OneToMany(targetEntity=Ligne::class, mappedBy="ligneTrain")
     */
    private $ligne;

    public function __construct()
    {
        $this->train = new ArrayCollection();
        $this->ligne = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoraireA(): ?\DateTimeInterface
    {
        return $this->horaireA;
    }

    public function setHoraireA(\DateTimeInterface $horaireA): self
    {
        $this->horaireA = $horaireA;

        return $this;
    }

    public function getHoraireD(): ?\DateTimeInterface
    {
        return $this->horaireD;
    }

    public function setHoraireD(\DateTimeInterface $horaireD): self
    {
        $this->horaireD = $horaireD;

        return $this;
    }

    /**
     * @return Collection|Train[]
     */
    public function getTrain(): Collection
    {
        return $this->train;
    }

    public function addTrain(Train $train): self
    {
        if (!$this->train->contains($train)) {
            $this->train[] = $train;
            $train->setLigneTrain($this);
        }

        return $this;
    }

    public function removeTrain(Train $train): self
    {
        if ($this->train->removeElement($train)) {
            // set the owning side to null (unless already changed)
            if ($train->getLigneTrain() === $this) {
                $train->setLigneTrain(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ligne[]
     */
    public function getLigne(): Collection
    {
        return $this->ligne;
    }

    public function addLigne(Ligne $ligne): self
    {
        if (!$this->ligne->contains($ligne)) {
            $this->ligne[] = $ligne;
            $ligne->setLigneTrain($this);
        }

        return $this;
    }

    public function removeLigne(Ligne $ligne): self
    {
        if ($this->ligne->removeElement($ligne)) {
            // set the owning side to null (unless already changed)
            if ($ligne->getLigneTrain() === $this) {
                $ligne->setLigneTrain(null);
            }
        }

        return $this;
    }
}
