<?php

namespace App\Entity;

use App\Repository\SuitesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuitesRepository::class)]
class Suites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $main_image;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'string', length: 255)]
    private $booking_link;

    #[ORM\ManyToOne(targetEntity: Establishment::class, inversedBy: 'suites')]
    #[ORM\JoinColumn(nullable: false)]
    private $establishment;

    #[ORM\OneToOne(mappedBy: 'suite', targetEntity: Gallery::class, cascade: ['persist', 'remove'])]
    private $gallery;

    public function __toString()
    {
        return $this->name.' - '.$this->price.'€ / la nuit';
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->main_image;
    }

    public function setMainImage(string $main_image): self
    {
        $this->main_image = $main_image;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getBookingLink(): ?string
    {
        return $this->booking_link;
    }

    public function setBookingLink(string $booking_link): self
    {
        $this->booking_link = $booking_link;

        return $this;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(?Establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(Gallery $gallery): self
    {
        // set the owning side of the relation if necessary
        if ($gallery->getSuite() !== $this) {
            $gallery->setSuite($this);
        }

        $this->gallery = $gallery;

        return $this;
    }
}
