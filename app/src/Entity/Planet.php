<?php

namespace App\Entity;

use App\Repository\PlanetRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanetRepository::class)]
class Planet
{
    #[ORM\Id]
    #[ORM\Column(unique: true)]
    #[Assert\Unique]
    #[Assert\NotNull]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $rotation_period = null;

    #[ORM\Column(nullable: true)]
    private ?int $orbital_period = null;

    #[ORM\Column(nullable: true)]
    private ?int $diameter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getRotationPeriod(): ?int
    {
        return $this->rotation_period;
    }

    public function setRotationPeriod(?int $rotation_period): self
    {
        $this->rotation_period = $rotation_period;

        return $this;
    }

    public function getOrbitalPeriod(): ?int
    {
        return $this->orbital_period;
    }

    public function setOrbitalPeriod(?int $orbital_period): self
    {
        $this->orbital_period = $orbital_period;

        return $this;
    }

    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    public function setDiameter(?int $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
