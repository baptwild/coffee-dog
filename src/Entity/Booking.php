<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Dog::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Dog $dog = null;

    #[ORM\ManyToOne(targetEntity: Rate::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Rate $rate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $effectiveDate = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalDatetime = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $departureDatetime = null;

    public const STATUS_EN_ATTENTE = 'en_attente';
    public const STATUS_CONFIRME = 'confirme';
    public const STATUS_ANNULE = 'annule';

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Invoice $invoice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getDog(): ?Dog
    {
        return $this->dog;
    }

    public function setDog(?Dog $dog): static
    {
        $this->dog = $dog;
        return $this;
    }
    public function getRate(): ?Rate
    {
        return $this->rate;
    }
    public function setRate(?Rate $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getEffectiveDate(): ?\DateTimeInterface
    {
        return $this->effectiveDate;
    }

    public function setEffectiveDate(?\DateTimeInterface $effectiveDate): static
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getArrivalDatetime(): ?\DateTimeInterface
    {
        return $this->arrivalDatetime;
    }
    public function setArrivalDatetime(?\DateTimeInterface $arrivalDatetime): static
    {
        $this->arrivalDatetime = $arrivalDatetime;

        return $this;
    }
    public function getDepartureDatetime(): ?\DateTimeInterface
    {
        return $this->departureDatetime;
    }
    public function setDepartureDatetime(?\DateTimeInterface $departureDatetime): static
    {
        $this->departureDatetime = $departureDatetime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $allowed = [
            self::STATUS_EN_ATTENTE,
            self::STATUS_CONFIRME,
            self::STATUS_ANNULE,
        ];
        if (!in_array($status, $allowed, true)) {
            throw new \InvalidArgumentException("Invalid status: $status");
        }

        $this->status = $status;

        return $this;
    }

    public function getDisplayStatus(): string
    {
        return match ($this->status) {
            self::STATUS_EN_ATTENTE => 'En attente',
            self::STATUS_CONFIRME => 'Confirmée',
            self::STATUS_ANNULE => 'Annulée',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
