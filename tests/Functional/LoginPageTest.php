<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginPageTest extends WebTestCase
{
    // TEST D'UNE URL, ICI LA PAGE D'ACCUEIL

    public function testSomething(): void
    {
        $client = static::createClient();
        // CONNECTION DE L'UTILISATEUR (AUTRE METHODE EXISTE)
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class, 6);
        $client->loginUser($user);

        // Route vers competition
        $crawler = $client->request('GET', '/competition/');

        // 
        $this->assertResponseIsSuccessful();

        // Regarde s'il existe une fonction avec la class d-flex
        $personnes = $crawler->filter('.d-flex');
        $this->assertEquals(1, count($personnes));

        // Regarde s'il existe un h1 nommé "Liste des competitions"
        $this->assertSelectorTextContains('h1', 'Liste des competitions');
    }
}
