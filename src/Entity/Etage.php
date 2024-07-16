<?php

namespace App\Entity;

use App\Repository\EtageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtageRepository::class)]
class Etage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'etages')]
    private ?Appartement $propriete = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPropriete(): ?Appartement
    {
        return $this->propriete;
    }

    public function setPropriete(?Appartement $propriete): static
    {
        $this->propriete = $propriete;

        return $this;
    }
}
