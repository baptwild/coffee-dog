<?php

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(targetEntity: Booking::class, mappedBy: 'rate')]

    
    // #[ORM\OneToMany(mappedBy:'rate', targetEntity: Booking::class, cascade: ['persist', 'remove'])]
    private Collection $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

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


    /**
     * @return Collection<int, Booking>
     */

    public function getBookings(): Collection
    {
        return $this->bookings;
    }


    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);

    
            $booking->setRate($this);
        }

        return $this;
    }


    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // Set the owning side to null (unless already changed)


            if ($booking->getRate() === $this) {
                $booking->setRate(null);
            }
        }

        return $this;
    }
}
