<?php

namespace App\Entity;

use App\Repository\SeatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeatRepository::class)
 */
class Seat
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Wagon::class, inversedBy="seats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wagon;

    /**
     * @ORM\OneToMany(targetEntity=BookingSeat::class, mappedBy="seat")
     */
    private $bookingSeats;

    public function __construct()
    {
        $this->bookingSeats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getWagon(): ?Wagon
    {
        return $this->wagon;
    }

    public function setWagon(?Wagon $wagon): self
    {
        $this->wagon = $wagon;

        return $this;
    }

    /**
     * @return Collection<int, BookingSeat>
     */
    public function getBookingSeats(): Collection
    {
        return $this->bookingSeats;
    }

    public function addBookingSeat(BookingSeat $bookingSeat): self
    {
        if (!$this->bookingSeats->contains($bookingSeat)) {
            $this->bookingSeats[] = $bookingSeat;
            $bookingSeat->setSeat($this);
        }

        return $this;
    }

    public function removeBookingSeat(BookingSeat $bookingSeat): self
    {
        if ($this->bookingSeats->removeElement($bookingSeat)) {
            // set the owning side to null (unless already changed)
            if ($bookingSeat->getSeat() === $this) {
                $bookingSeat->setSeat(null);
            }
        }

        return $this;
    }
}
