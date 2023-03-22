<?php

namespace App\Entity;

use App\Repository\CategorieJeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieJeuRepository::class)
 */
class CategorieJeu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Jeu::class, inversedBy="lesCategories")
     */
    private $lesJeux;

    public function __construct()
    {
        $this->lesJeux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Jeu>
     */
    public function getLesJeux(): Collection
    {
        return $this->lesJeux;
    }

    public function addLesJeux(Jeu $lesJeux): self
    {
        if (!$this->lesJeux->contains($lesJeux)) {
            $this->lesJeux[] = $lesJeux;
        }

        return $this;
    }

    public function removeLesJeux(Jeu $lesJeux): self
    {
        $this->lesJeux->removeElement($lesJeux);

        return $this;
    }
}
