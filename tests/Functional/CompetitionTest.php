<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionTest extends WebTestCase
{
    public function testSomething(): void
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

        $form["competition[nom]"] = "testCompetition";
        $form["competition[Statut]"] = "Bientot";
        $form["competition[dateDebut][day]"] = "17";
        $form["competition[dateDebut][month]"] = "1";
        $form["competition[dateDebut][year]"] = "2018";
        $form["competition[gainPossible]"] = "1000";
        $form["competition[equipe]"] = "Les Rois";

        // Soumettre le formulaire

        $client->submit($form);

        // Vérifier le statut HTTP

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
        // Vérifier l'envoie du mail (non)

        $client->followRedirect();

        // Vérifier la présence du message de succès

    }
}
