<?php

namespace App\Entity;

use App\Repository\EthRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EthRepository::class)]
class Eth
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceToday = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceOneDayBefore = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceTwoDaysBefore = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceThreeDaysBefore = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceFourDaysBefore = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceFiveDaysBefore = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $priceSixDaysBefore = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceToday(): ?string
    {
        return $this->priceToday;
    }

    public function setPriceToday(string $priceToday): static
    {
        $this->priceToday = $priceToday;

        return $this;
    }

    public function getPriceOneDayBefore(): ?string
    {
        return $this->priceOneDayBefore;
    }

    public function setPriceOneDayBefore(string $priceOneDayBefore): static
    {
        $this->priceOneDayBefore = $priceOneDayBefore;

        return $this;
    }

    public function getPriceTwoDaysBefore(): ?string
    {
        return $this->priceTwoDaysBefore;
    }

    public function setPriceTwoDaysBefore(string $priceTwoDaysBefore): static
    {
        $this->priceTwoDaysBefore = $priceTwoDaysBefore;

        return $this;
    }

    public function getPriceThreeDaysBefore(): ?string
    {
        return $this->priceThreeDaysBefore;
    }

    public function setPriceThreeDaysBefore(string $priceThreeDaysBefore): static
    {
        $this->priceThreeDaysBefore = $priceThreeDaysBefore;

        return $this;
    }

    public function getPriceFourDaysBefore(): ?string
    {
        return $this->priceFourDaysBefore;
    }

    public function setPriceFourDaysBefore(string $priceFourDaysBefore): static
    {
        $this->priceFourDaysBefore = $priceFourDaysBefore;

        return $this;
    }

    public function getPriceFiveDaysBefore(): ?string
    {
        return $this->priceFiveDaysBefore;
    }

    public function setPriceFiveDaysBefore(string $priceFiveDaysBefore): static
    {
        $this->priceFiveDaysBefore = $priceFiveDaysBefore;

        return $this;
    }

    public function getPriceSixDaysBefore(): ?string
    {
        return $this->priceSixDaysBefore;
    }

    public function setPriceSixDaysBefore(string $priceSixDaysBefore): static
    {
        $this->priceSixDaysBefore = $priceSixDaysBefore;

        return $this;
    }
}
