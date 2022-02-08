<?php

namespace App\Entity;

use App\Repository\LineTrainRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineTrainRepository::class)
 */
class LineTrain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Train::class, inversedBy="lineTrains")
     */
    private $train;

    /**
     * @ORM\ManyToOne(targetEntity=Line::class, inversedBy="lineTrains")
     */
    private $line;

    /**
     * @ORM\Column(type="date")
     */
    private $date_departure;

    /**
     * @ORM\Column(type="date")
     */
    private $date_arrival;

    /**
     * @ORM\Column(type="time")
     */
    private $time_departure;

    /**
     * @ORM\Column(type="time")
     */
    private $time_arrival;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLine(): ?Line
    {
        return $this->line;
    }

    public function setLine(?Line $line): self
    {
        $this->line = $line;

        return $this;
    }

    public function getDateDeparture(): ?\DateTimeInterface
    {
        return $this->date_departure;
    }

    public function setDateDeparture(\DateTimeInterface $date_departure): self
    {
        $this->date_departure = $date_departure;

        return $this;
    }

    public function getDateArrival(): ?\DateTimeInterface
    {
        return $this->date_arrival;
    }

    public function setDateArrival(\DateTimeInterface $date_arrival): self
    {
        $this->date_arrival = $date_arrival;

        return $this;
    }

    public function getTimeDeparture(): ?\DateTimeInterface
    {
        return $this->time_departure;
    }

    public function setTimeDeparture(\DateTimeInterface $time_departure): self
    {
        $this->time_departure = $time_departure;

        return $this;
    }

    public function getTimeArrival(): ?\DateTimeInterface
    {
        return $this->time_arrival;
    }

    public function setTimeArrival(\DateTimeInterface $time_arrival): self
    {
        $this->time_arrival = $time_arrival;

        return $this;
    }
}
