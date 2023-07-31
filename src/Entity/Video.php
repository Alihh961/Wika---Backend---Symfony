<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video extends Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id = null;


    public function getId(): ?int
    {
        return $this->id;
    }
    #[ORM\Column]
    private ?int $duration = null;

    // Getters and setters for the specific property

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }
}
