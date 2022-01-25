<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\WagonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WagonRepository::class)
 */
class Wagon
{

    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $class;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $placeNb;

    /**
     * @ORM\ManyToOne(targetEntity=Train::class, inversedBy="wagons")
     */
    private $train;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="wagons")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Option::class, inversedBy="wagons")
     */
    private $option;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPlaceNb(): ?int
    {
        return $this->placeNb;
    }

    public function setPlaceNb(int $placeNb): self
    {
        $this->placeNb = $placeNb;

        return $this;
    }

    public function getTrain(): ?Train
    {
        return $this->train;
    }

    public function setTrain(?Train $train): self
    {
        $this->train = $train;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getOption(): ?Option
    {
        return $this->option;
    }

    public function setOption(?Option $option): self
    {
        $this->option = $option;

        return $this;
    }
}
