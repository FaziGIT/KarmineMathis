<?php

namespace App\Tests\Unit;

use App\Entity\Lieu;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LieuTest extends KernelTestCase
{

// TEST UNE ENTITY PERSONNE AVEC ASSERT 

    // Remplissage d'une personne via l'entity
    public function getEntity() : Lieu 
    {
        return (new Lieu())->setSalle('Salle')
                                ->setVille('Ville')
                                ->setPays('Payss');
    }

    // Fonction qui test si le remplissage de l'entity est correct
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $personne = new Lieu();
        $personne = $this->getEntity();
        
        $errors = $container->get('validator')->validate($personne);

        // Permet de prévoir le nombre d'erreurn, 0 ici
        $this->assertCount(0, $errors);
    }

    // Fonction qui test si le remplissage de l'entity est correct, ici pas correct car Pseudo vide
    public function testInvalidLieu()
    {
        self::bootKernel();
        $container = static::getContainer();

        $personne = new Lieu();
        $personne = $this->getEntity();
        // Changement du pseudo pour faire en sorte qu'il soit vide = erreur
        $personne->setSalle('');

        $errors = $container->get('validator')->validate($personne);

        // Permet de prévoir le nombre d'erreur, 1 ici
        $this->assertCount(2, $errors);
    }
}
