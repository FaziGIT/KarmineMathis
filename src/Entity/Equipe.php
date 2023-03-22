<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Personne::class, mappedBy="coach")
     */
    private $leCoach;

    /**
     * @ORM\OneToMany(targetEntity=Personne::class, mappedBy="joueur")
     */
    private $leJoueur;

    /**
     * @ORM\ManyToOne(targetEntity=Jeu::class, inversedBy="lesEquipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $leJeu;

    /**
     * @ORM\OneToMany(targetEntity=Competition::class, mappedBy="equipe")
     */
    private $competition;



    public function __construct()
    {
        $this->leCoach = new ArrayCollection();
        $this->leJoueur = new ArrayCollection();
        $this->competition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getLeCoach(): Collection
    {
        return $this->leCoach;
    }

    public function addLeCoach(Personne $leCoach): self
    {
        if (!$this->leCoach->contains($leCoach)) {
            $this->leCoach[] = $leCoach;
            $leCoach->setCoach($this);
        }

        return $this;
    }

    public function removeLeCoach(Personne $leCoach): self
    {
        if ($this->leCoach->removeElement($leCoach)) {
            // set the owning side to null (unless already changed)
            if ($leCoach->getCoach() === $this) {
                $leCoach->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getLeJoueur(): Collection
    {
        return $this->leJoueur;
    }

    public function addLeJoueur(Personne $leJoueur): self
    {
        if (!$this->leJoueur->contains($leJoueur)) {
            $this->leJoueur[] = $leJoueur;
            $leJoueur->setJoueur($this);
        }

        return $this;
    }

    public function removeLeJoueur(Personne $leJoueur): self
    {
        if ($this->leJoueur->removeElement($leJoueur)) {
            // set the owning side to null (unless already changed)
            if ($leJoueur->getJoueur() === $this) {
                $leJoueur->setJoueur(null);
            }
        }

        return $this;
    }

    public function getLeJeu(): ?Jeu
    {
        return $this->leJeu;
    }

    public function setLeJeu(?Jeu $leJeu): self
    {
        $this->leJeu = $leJeu;

        return $this;
    }

    /**
     * @return Collection<int, Competition>
     */
    public function getCompetition(): Collection
    {
        return $this->competition;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competition->contains($competition)) {
            $this->competition[] = $competition;
            $competition->setEquipe($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competition->removeElement($competition)) {
            // set the owning side to null (unless already changed)
            if ($competition->getEquipe() === $this) {
                $competition->setEquipe(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
