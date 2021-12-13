<?php

namespace App\Entity;

use App\Repository\TrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrainRepository::class)
 */
class Train
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Wagon::class, mappedBy="train")
     */
    private $wagons;

    /**
     * @ORM\ManyToOne(targetEntity=LigneTrain::class, inversedBy="train")
     */
    private $ligneTrain;

    public function __construct()
    {
        $this->wagons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Wagon[]
     */
    public function getWagons(): Collection
    {
        return $this->wagons;
    }

    public function addWagon(Wagon $wagon): self
    {
        if (!$this->wagons->contains($wagon)) {
            $this->wagons[] = $wagon;
            $wagon->setTrain($this);
        }

        return $this;
    }

    public function removeWagon(Wagon $wagon): self
    {
        if ($this->wagons->removeElement($wagon)) {
            // set the owning side to null (unless already changed)
            if ($wagon->getTrain() === $this) {
                $wagon->setTrain(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getLigneTrain(): ?LigneTrain
    {
        return $this->ligneTrain;
    }

    public function setLigneTrain(?LigneTrain $ligneTrain): self
    {
        $this->ligneTrain = $ligneTrain;

        return $this;
    }
}
