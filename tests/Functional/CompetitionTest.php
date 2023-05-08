<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionTest extends WebTestCase
{
    // TEST DU FORMULAIRE
    public function testIfFormCompetitionIsSuccessful(): void
    {
        $client = static::createClient();
        
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        $user = $entityManager->find(User::class, 6);
        $client->loginUser($user);
        $crawler = $client->request('GET', '/competition/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Crée une compétition');

        // Récupérer le formulaire

        $submitButton = $crawler->selectButton('Sauvegarder');
        $form = $submitButton->form();

        // Soumettre le formulaire
        $client->submit($form, [
            'competition[nom]'    => 'testCompetition',
            'competition[Statut]' => 'Bientot',
            'competition[dateDebut][day]' => '17',
            'competition[dateDebut][month]' => '1',
            'competition[dateDebut][year]' => '2020',
            'competition[dateFin][day]' => '17',
            'competition[dateFin][month]' => '1',
            'competition[dateFin][year]' => '2021',
            'competition[gainPossible]' => '1000',
            'competition[equipe]' => 17,
        ]);

        // Vérifier le statut HTTP
        $this->assertResponseStatusCodeSame(303);
        
        // Redirection vers la page prévu (ici Competition)
        $client->followRedirect();

        // Vérifier la présence du message de succès
        $this->assertSelectorTextContains(
            'div.alert.alert-success',
            'La compétition à bien été ajoutée'
        );
    }
}
