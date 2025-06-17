<?php

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RateRepository::class)]
class Rate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $rate = null;

    #[ORM\Column(length: 255)]
    private ?string $rateType = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\OneToOne(mappedBy:'rate', targetEntity: Booking::class, cascade: ['persist', 'remove'])]
    // #[ORM\JoinColumn(nullable: false)]
    private ?Booking $bookings = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getRateType(): ?string
    {
        return $this->rateType;
    }

    public function setRateType(string $rateType): static
    {
        $this->rateType = $rateType;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getBookings(): ?Booking
    {
        return $this->bookings;
    }
    public function setBookings(?Booking $bookings): self
    {
        // set the owning side of the relation if necessary
        if ($bookings !== null && $bookings->getRate() !== $this) {
            $bookings->setRate($this);
        }

        $this->bookings = $bookings;

        return $this;
    }
}
