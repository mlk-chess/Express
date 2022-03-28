<?php

namespace App\Entity;

use App\Repository\LineTrainRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull
     */
    private $train;

    /**
     * @ORM\ManyToOne(targetEntity=Line::class, inversedBy="lineTrains")
     * @Assert\NotNull
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

     /**
      * @ORM\Column(type="integer")
      */
    private $place_nb_class_1;

      /**
       * @ORM\Column(type="integer")
       */
    private $place_nb_class_2;

      /**
      * @ORM\Column(type="float")
      */
    private $price_class_1;

      /**
       * @ORM\Column(type="float")
       */
    private $price_class_2;

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


    public function getPlaceNbClass1(): ?int
    {
        return $this->place_nb_class_1;
    }

    public function setPlaceNbClass1(int $placeNbClass1): self
    {
        $this->place_nb_class_1 = $placeNbClass1;

        return $this;
    }

    public function getPlaceNbClass2(): ?int
    {
        return $this->place_nb_class_2;
    }

    public function setPlaceNbClass2(int $placeNbClass2): self
    {
        $this->place_nb_class_2 = $placeNbClass2;

        return $this;
    }

    public function getPriceClass1(): ?float
    {
        return $this->price_class_1;
    }

    public function setPriceClass1(float $priceClass1): self
    {
        $this->price_class_1 = $priceClass1;

        return $this;
    }

    public function getPriceClass2(): ?float
    {
        return $this->price_class_2;
    }

    public function setPriceClass2(int $priceClass2): self
    {
        $this->price_class_2 = $priceClass2;

        return $this;
    }
}
