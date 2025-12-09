<?php

namespace App\Entity;

use App\Repository\FraisForfaitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

use function PHPUnit\Framework\exactly;

#[ORM\Entity(repositoryClass: FraisForfaitRepository::class)]
class FraisForfait
{
    #[Assert\Length(exactly: 3)]
    #[Assert\NotBlank]
    #[Assert\Regex("/^[A-Z]{3}$/", "L'indentifiant doit être composer de 3 lettres en majuscules.")]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(length: 3)]
    private ?string $id = null;


    #[ORM\Column(length: 20, nullable: true)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $motant = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->motant;
    }

    public function setMontant(?string $motant): static
    {
        $this->motant = $motant;

        return $this;
    }

     public function setId(?string $id): static
    {
        $this->id = $id;

        return $this;
    }
}
