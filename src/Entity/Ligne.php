<?php

namespace App\Entity;

use App\Repository\LigneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigneRepository::class)
 */
class Ligne
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
    private $longitudeGareD;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LatitudeGareD;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LongitudeGareA;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $LatitudeGareA;

    /**
     * @ORM\ManyToOne(targetEntity=LigneTrain::class, inversedBy="ligne")
     */
    private $ligneTrain;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitudeGareD(): ?string
    {
        return $this->longitudeGareD;
    }

    public function setLongitudeGareD(string $longitudeGareD): self
    {
        $this->longitudeGareD = $longitudeGareD;

        return $this;
    }

    public function getLatitudeGareD(): ?string
    {
        return $this->LatitudeGareD;
    }

    public function setLatitudeGareD(string $LatitudeGareD): self
    {
        $this->LatitudeGareD = $LatitudeGareD;

        return $this;
    }

    public function getLongitudeGareA(): ?string
    {
        return $this->LongitudeGareA;
    }

    public function setLongitudeGareA(string $LongitudeGareA): self
    {
        $this->LongitudeGareA = $LongitudeGareA;

        return $this;
    }

    public function getLatitudeGareA(): ?string
    {
        return $this->LatitudeGareA;
    }

    public function setLatitudeGareA(string $LatitudeGareA): self
    {
        $this->LatitudeGareA = $LatitudeGareA;

        return $this;
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
