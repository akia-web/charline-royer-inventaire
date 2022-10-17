<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Material $material = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $empruntDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $rendered = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $isRendered = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getEmpruntDate(): ?\DateTimeInterface
    {
        return $this->empruntDate;
    }

    public function setEmpruntDate(\DateTimeInterface $empruntDate): self
    {
        $this->empruntDate = $empruntDate;

        return $this;
    }

    public function getRendered(): ?\DateTimeInterface
    {
        return $this->rendered;
    }

    public function setRendered(\DateTimeInterface $rendered): self
    {
        $this->rendered = $rendered;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isIsRendered(): ?bool
    {
        return $this->isRendered;
    }

    public function setIsRendered(bool $isRendered): self
    {
        $this->isRendered = $isRendered;

        return $this;
    }
}
