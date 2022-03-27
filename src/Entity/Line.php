<?php

namespace App\Entity;

use App\Repository\LineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineRepository::class)
 */
class Line
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
    private $longitude_departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitude_departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitude_arrival;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitude_arrival;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_station_departure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name_station_arrival;

    /**
     * @ORM\OneToMany(targetEntity=LineTrain::class, mappedBy="line")
     */
    private $lineTrains;

    public function __construct()
    {
        $this->lineTrains = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitudeDeparture(): ?string
    {
        return $this->longitude_departure;
    }

    public function setLongitudeDeparture(string $longitude_departure): self
    {
        $this->longitude_departure = $longitude_departure;

        return $this;
    }

    public function getLatitudeDeparture(): ?string
    {
        return $this->latitude_departure;
    }

    public function setLatitudeDeparture(string $latitude_departure): self
    {
        $this->latitude_departure = $latitude_departure;

        return $this;
    }

    public function getLongitudeArrival(): ?string
    {
        return $this->longitude_arrival;
    }

    public function setLongitudeArrival(string $longitude_arrival): self
    {
        $this->longitude_arrival = $longitude_arrival;

        return $this;
    }

    public function getLatitudeArrival(): ?string
    {
        return $this->latitude_arrival;
    }

    public function setLatitudeArrival(string $latitude_arrival): self
    {
        $this->latitude_arrival = $latitude_arrival;

        return $this;
    }

    public function getNameStationDeparture(): ?string
    {
        return $this->name_station_departure;
    }

    public function setNameStationDeparture(string $name_station_departure): self
    {
        $this->name_station_departure = $name_station_departure;

        return $this;
    }

    public function getNameStationArrival(): ?string
    {
        return $this->name_station_arrival;
    }

    public function setNameStationArrival(string $name_station_arrival): self
    {
        $this->name_station_arrival = $name_station_arrival;

        return $this;
    }
    public function __toString()
    {
        return $this->name_station_arrival;
    }

    /**
     * @return Collection|LineTrain[]
     */
    public function getLineTrains(): Collection
    {
        return $this->lineTrains;
    }

    public function addLineTrain(LineTrain $lineTrain): self
    {
        if (!$this->lineTrains->contains($lineTrain)) {
            $this->lineTrains[] = $lineTrain;
            $lineTrain->setLine($this);
        }

        return $this;
    }

    public function removeLineTrain(LineTrain $lineTrain): self
    {
        if ($this->lineTrains->removeElement($lineTrain)) {
            // set the owning side to null (unless already changed)
            if ($lineTrain->getLine() === $this) {
                $lineTrain->setLine(null);
            }
        }

        return $this;
    }
}
