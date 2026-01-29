<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use DateTimeInterface;
use App\Repository\PersonneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $sexe = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $role = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $nationalite = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $liquipedia = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: 'leCoach')]
    private ?Equipe $coach = null;

    #[ORM\ManyToOne(targetEntity: Equipe::class, inversedBy: 'leJoueur')]
    private ?Equipe $joueur = null;

    public function __construct()
    {
        $this->setImage('userVierge.png');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDateNaissance(): ?DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

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

    public function getLiquipedia(): ?string
    {
        return $this->liquipedia;
    }

    public function setLiquipedia(?string $liquipedia): self
    {
        $this->liquipedia = $liquipedia;

        return $this;
    }

    public function getCoach(): ?Equipe
    {
        return $this->coach;
    }

    public function setCoach(?Equipe $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getJoueur(): ?Equipe
    {
        return $this->joueur;
    }

    public function setJoueur(?Equipe $joueur): self
    {
        $this->joueur = $joueur;

        return $this;
    }
}
