<?php

namespace App\Entity;

use App\Repository\FicheFraisRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FicheFraisRepository::class)]
class FicheFrais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['fichesfrais.general'])]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    #[Groups(['fichesfrais.general'])]
    private ?string $mois = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['fichesfrais.general'])]
    private ?int $nbJustificatifs = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['fichesfrais.general'])]
    private ?string $montantValide = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['fichesfrais.general'])]
    private ?\DateTime $dateModif = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['fichesfrais.general'])]
    private ?Etat $etat = null;

    #[ORM\ManyToOne(inversedBy: 'ffs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['fichesfrais.general'])]
    private ?Visiteur $visiteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getNbJustificatifs(): ?int
    {
        return $this->nbJustificatifs;
    }

    public function setNbJustificatifs(int $nbJustificatifs): static
    {
        $this->nbJustificatifs = $nbJustificatifs;

        return $this;
    }

    public function getMontantValide(): ?string
    {
        return $this->montantValide;
    }

    public function setMontantValide(string $montantValide): static
    {
        $this->montantValide = $montantValide;

        return $this;
    }

    public function getDateModif(): ?\DateTime
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTime $dateModif): static
    {
        $this->dateModif = $dateModif;

        return $this;
    }


    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getVisiteur(): ?Visiteur
    {
        return $this->visiteur;
    }

    public function setVisiteur(?Visiteur $visiteur): static
    {
        $this->visiteur = $visiteur;

        return $this;
    }
}
