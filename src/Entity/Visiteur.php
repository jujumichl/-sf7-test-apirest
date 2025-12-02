<?php

namespace App\Entity;

use App\Repository\VisiteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: VisiteurRepository::class)]
class Visiteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    #[ORM\Column(length: 4)]
    #[Groups(['fichesfrais.general'])]
    private ?string $id = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Groups(['fichesfrais.general'])]
    private ?string $nom = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Groups(['fichesfrais.general'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 30)]
    #[Groups(['fichesfrais.general'])]
    private ?string $login = null;

    #[ORM\Column(length: 30)]
    #[Groups(['fichesfrais.general'])]
    private ?string $mdp = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['fichesfrais.general'])]
    private ?string $adresse = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups(['fichesfrais.general'])]
    private ?string $cp = null;

    #[ORM\Column(length: 30, nullable: true)]
    #[Groups(['fichesfrais.general'])]
    private ?string $ville = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['fichesfrais.general'])]
    private ?\DateTime $dateEmbauche = null;

    /**
     * @var Collection<int, FicheFrais>
     */
    #[ORM\OneToMany(targetEntity: FicheFrais::class, mappedBy: 'visiteur', orphanRemoval: true)]
    private Collection $ffs;

    public function __construct()
    {
        $this->ffs = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTime
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(\DateTime $dateEmbauche): static
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    /**
     * @return Collection<int, FicheFrais>
     */
    public function getFfs(): Collection
    {
        return $this->ffs;
    }

    public function addFf(FicheFrais $ff): static
    {
        if (!$this->ffs->contains($ff)) {
            $this->ffs->add($ff);
            $ff->setVisiteur($this);
        }

        return $this;
    }

    public function removeFf(FicheFrais $ff): static
    {
        if ($this->ffs->removeElement($ff)) {
            // set the owning side to null (unless already changed)
            if ($ff->getVisiteur() === $this) {
                $ff->setVisiteur(null);
            }
        }

        return $this;
    }
}
