<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idStripe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paymentIntent;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateBooking;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=LineTrain::class, inversedBy="bookings",fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lineTrain;

    /**
     * @ORM\Column(type="integer")
     */

    private $status;
    /**
     * @ORM\Column(type="json")
     */
    private $travelers = [];

    /**
     * @ORM\OneToMany(targetEntity=BookingSeat::class, mappedBy="booking")
     */
    private $bookingSeats;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    public function __construct()
    {
        $this->bookingSeats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIdStripe(): ?string
    {
        return $this->idStripe;
    }

    public function setIdStripe(string $idStripe): self
    {
        $this->idStripe = $idStripe;

        return $this;
    }

    public function getPaymentIntent(): ?string
    {
        return $this->paymentIntent;
    }

    public function setPaymentIntent(string $paymentIntent): self
    {
        $this->paymentIntent = $paymentIntent;

        return $this;
    }

    public function getDateBooking(): ?\DateTimeInterface
    {
        return $this->dateBooking;
    }

    public function setDateBooking(\DateTimeInterface $dateBooking): self
    {
        $this->dateBooking = $dateBooking;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getLineTrain(): ?LineTrain
    {
        return $this->lineTrain;
    }

    public function setLineTrain(?LineTrain $lineTrain): self
    {
        $this->lineTrain = $lineTrain;

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
            $bookingSeat->setBooking($this);
        }

        return $this;
    }

    public function removeBookingSeat(BookingSeat $bookingSeat): self
    {
        if ($this->bookingSeats->removeElement($bookingSeat)) {
            // set the owning side to null (unless already changed)
            if ($bookingSeat->getBooking() === $this) {
                $bookingSeat->setBooking(null);
            }
        }
    }
    public function getTravelers(): array
    {
        $travelers = $this->travelers;

        return $travelers;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setTravelers(array $travelers): self
    {
        $this->travelers = $travelers;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
