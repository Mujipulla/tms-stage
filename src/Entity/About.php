<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutRepository::class)]
class About
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $aboutImage = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $aboutText = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAboutImage(): ?string
    {
        return $this->aboutImage;
    }

    public function setAboutImage(string $aboutImage): self
    {
        $this->aboutImage = $aboutImage;

        return $this;
    }

    public function getAboutText(): ?string
    {
        return $this->aboutText;
    }

    public function setAboutText(string $aboutText): self
    {
        $this->aboutText = $aboutText;

        return $this;
    }
}
