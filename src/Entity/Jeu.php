<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JeuRepository::class)
 */
class Jeu
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
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="leJeu")
     */
    private $lesEquipes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=CategorieJeu::class, mappedBy="lesJeux")
     */
    private $lesCategories;

    public function __construct()
    {
        $this->lesEquipes = new ArrayCollection();
        $this->lesCategories = new ArrayCollection();
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
     * @return Collection<int, Equipe>
     */
    public function getLesEquipes(): Collection
    {
        return $this->lesEquipes;
    }

    public function addLesEquipe(Equipe $lesEquipe): self
    {
        if (!$this->lesEquipes->contains($lesEquipe)) {
            $this->lesEquipes[] = $lesEquipe;
            $lesEquipe->setLeJeu($this);
        }

        return $this;
    }

    public function removeLesEquipe(Equipe $lesEquipe): self
    {
        if ($this->lesEquipes->removeElement($lesEquipe)) {
            // set the owning side to null (unless already changed)
            if ($lesEquipe->getLeJeu() === $this) {
                $lesEquipe->setLeJeu(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, CategorieJeu>
     */
    public function getLesCategories(): Collection
    {
        return $this->lesCategories;
    }

    public function addLesCategory(CategorieJeu $lesCategory): self
    {
        if (!$this->lesCategories->contains($lesCategory)) {
            $this->lesCategories[] = $lesCategory;
            $lesCategory->addLesJeux($this);
        }

        return $this;
    }

    public function removeLesCategory(CategorieJeu $lesCategory): self
    {
        if ($this->lesCategories->removeElement($lesCategory)) {
            $lesCategory->removeLesJeux($this);
        }

        return $this;
    }
}
