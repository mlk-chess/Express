<?php

namespace App\Entity;

use App\Repository\LineTrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=Train::class, inversedBy="lineTrains",fetch="EAGER")
     * @Assert\NotNull
     */
    private $train;

    /**
     * @ORM\ManyToOne(targetEntity=Line::class, inversedBy="lineTrains")
     * @Assert\NotBlank
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
     * 
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
      * @Assert\NotNull
      */
    private $price_class_1;

      /**
       * @ORM\Column(type="float")
       * @Assert\NotNull
       */
    private $price_class_2;

      /**
       * @ORM\Column(type="integer")

       */
      private $status = 0;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="lineTrain")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

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

    public function setPriceClass2(float $priceClass2): self
    {
        $this->price_class_2 = $priceClass2;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setLineTrain($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getLineTrain() === $this) {
                $booking->setLineTrain(null);
            }
        }

        return $this;
    }
}
