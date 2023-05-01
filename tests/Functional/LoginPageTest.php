<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginPageTest extends WebTestCase
{
    public function testSomething(): void
    {

        // TEST ROUTES / URL 
        $client = static::createClient();
        
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class, 6);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/competition/');
        // $this->assertResponseStatusCodeSame(301);
        $this->assertResponseIsSuccessful();
        // dd($crawler);



        // $personnes = $crawler->filter('.d-flex');
        // $this->assertEquals(1, count($personnes));
        // $crawler->filter('h1');
        $this->assertSelectorTextContains('h1', 'Liste des competitions');
    }
}
