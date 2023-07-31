<?php

namespace App\Entity;

use App\Repository\AudioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioRepository::class)]
class Audio extends Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id = null;


    public function getId(): ?int
    {
        return $this->id;
    }
    #[ORM\Column(length: 255)]
    private ?string $artist = null;

    // Getters and setters for the specific property

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(string $artist): self
    {
        $this->artist = $artist;
        return $this;
    }
}
