<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image extends Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id = null;


    public function getId(): ?int
    {
        return $this->id;
    }
    #[ORM\Column(length: 255)]
    private ?string $resolution = null;

    // Getters and setters for the specific property

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(string $resolution): self
    {
        $this->resolution = $resolution;
        return $this;
    }
}
