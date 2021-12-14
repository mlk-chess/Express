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
     * @ORM\Column(type="datetime")
     */
    private $schedule_departure;

    /**
     * @ORM\Column(type="datetime")
     */
    private $schedule_arrival;

    /**
     * @ORM\ManyToOne(targetEntity=Train::class, inversedBy="lineTrains")
     */
    private $train;

    /**
     * @ORM\ManyToOne(targetEntity=Line::class, inversedBy="lineTrains")
     */
    private $line;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScheduleDeparture(): ?\DateTimeInterface
    {
        return $this->schedule_departure;
    }

    public function setScheduleDeparture(\DateTimeInterface $schedule_departure): self
    {
        $this->schedule_departure = $schedule_departure;

        return $this;
    }

    public function getScheduleArrival(): ?\DateTimeInterface
    {
        return $this->schedule_arrival;
    }

    public function setScheduleArrival(\DateTimeInterface $schedule_arrival): self
    {
        $this->schedule_arrival = $schedule_arrival;

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

    public function getLine(): ?Line
    {
        return $this->line;
    }

    public function setLine(?Line $line): self
    {
        $this->line = $line;

        return $this;
    }
}
