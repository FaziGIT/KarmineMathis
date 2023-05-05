<?php

namespace App\Model;
use App\Entity\Equipe;
use Symfony\Component\Validator\Constraints as Assert;

class FiltrePersonne

{

    /**
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Le nom de famille de la personne doit comporter au minimum {{ limit }} caractères",
     * )
     */
    public string $nom;

    public Equipe $coach;
    
    public Equipe $joueur;
}

?>