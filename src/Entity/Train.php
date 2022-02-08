<?php

namespace App\Entity;
use App\Entity\Traits\TimestampableTrait;

use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\TrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=TrainRepository::class)
 */
class Train
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
     * @Assert\NotBlank(message="error.not.blank")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Wagon::class, mappedBy="train", cascade={"remove"})
     */
    private $wagons;

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @var string|null
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=LineTrain::class, mappedBy="train")
     */
    private $lineTrains;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trains")
     * @ORM\JoinColumn(nullable=true)
     * @Gedmo\Blameable(on="create")
     */
    private $owner;



    public function __construct()
    {
        $this->wagons = new ArrayCollection();
        $this->lineTrains = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
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
        return $this->name;
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
            $lineTrain->setTrain($this);
        }

        return $this;
    }

    public function removeLineTrain(LineTrain $lineTrain): self
    {
        if ($this->lineTrains->removeElement($lineTrain)) {
            // set the owning side to null (unless already changed)
            if ($lineTrain->getTrain() === $this) {
                $lineTrain->setTrain(null);
            }
        }

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
}
