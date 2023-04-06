<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginPageTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class, 6);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/');
        // $this->assertResponseStatusCodeSame(301);
        $this->assertResponseIsSuccessful();



        // $personnes = $crawler->filter('.d-flex');
        // $this->assertEquals(1, count($personnes));
        // $crawler->filter('h1');
        $this->assertSelectorTextContains('h1', 'News');
    }
}
