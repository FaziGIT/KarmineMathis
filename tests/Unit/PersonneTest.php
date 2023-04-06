<?php

namespace App\Tests\Unit;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PersonneTest extends KernelTestCase
{

    public function getEntity() : Personne 
    {
        return (new Personne())->setPseudo('Fazi')
                                ->setPrenom('Mathis')
                                ->setNom('TSRT')
                                ->setDateNaissance(new \DateTimeImmutable());
    }
    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $personne = new Personne();
        $personne = $this->getEntity();
        
        $errors = $container->get('validator')->validate($personne);

        $this->assertCount(0, $errors);
    }

    public function testInvalidPseudo()
    {
        self::bootKernel();
        $container = static::getContainer();

        $personne = new Personne();
        $personne = $this->getEntity();
        $personne->setPseudo('');

        $errors = $container->get('validator')->validate($personne);

        $this->assertCount(1, $errors);
    }
}
