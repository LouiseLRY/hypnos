<?php

namespace App\Entity;

use App\Repository\EstablishmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstablishmentRepository::class)]
class Establishment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\Column(type: 'string', length: 100)]
    private $city;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'establishment', targetEntity: Suites::class)]
    private $suites;


    #[ORM\OneToOne(mappedBy: 'establishment', targetEntity: Manager::class, cascade: ['persist', 'remove'])]
    private $manager;

    #[ORM\OneToMany(mappedBy: 'establishment', targetEntity: Booking::class)]
    private $bookings;

    public function __construct()
    {
        $this->suites = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->city.' - '.$this->name;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Suites>
     */
    public function getSuites(): Collection
    {
        return $this->suites;
    }

    public function addSuite(Suites $suite): self
    {
        if (!$this->suites->contains($suite)) {
            $this->suites[] = $suite;
            $suite->setEstablishment($this);
        }

        return $this;
    }

    public function removeSuite(Suites $suite): self
    {
        if ($this->suites->removeElement($suite)) {
            // set the owning side to null (unless already changed)
            if ($suite->getEstablishment() === $this) {
                $suite->setEstablishment(null);
            }
        }

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->Manager;
    }

    public function setManager(?Manager $Manager): self
    {
        // unset the owning side of the relation if necessary
        if ($Manager === null && $this->Manager !== null) {
            $this->Manager->setEstablishment(null);
        }

        // set the owning side of the relation if necessary
        if ($Manager !== null && $Manager->getEstablishment() !== $this) {
            $Manager->setEstablishment($this);
        }

        $this->Manager = $Manager;

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
            $booking->setEstablishment($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getEstablishment() === $this) {
                $booking->setEstablishment(null);
            }
        }

        return $this;
    }
}
