<?php

namespace App\Test\Controller;

use App\Entity\Competition;
use App\Repository\CompetitionRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompetitionControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompetitionRepository $repository;
    private string $path = '/competition/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Competition::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Competition index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'competition[nom]' => 'Testing',
            'competition[Statut]' => 'Testing',
            'competition[dateDebut]' => 'Testing',
            'competition[gainPossible]' => 'Testing',
            'competition[dateFin]' => 'Testing',
            'competition[lesEquipes]' => 'Testing',
        ]);

        self::assertResponseRedirects('/competition/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Competition();
        $fixture->setNom('My Title');
        $fixture->setStatut('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setGainPossible('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setLesEquipes('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Competition');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Competition();
        $fixture->setNom('My Title');
        $fixture->setStatut('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setGainPossible('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setLesEquipes('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'competition[nom]' => 'Something New',
            'competition[Statut]' => 'Something New',
            'competition[dateDebut]' => 'Something New',
            'competition[gainPossible]' => 'Something New',
            'competition[dateFin]' => 'Something New',
            'competition[lesEquipes]' => 'Something New',
        ]);

        self::assertResponseRedirects('/competition/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getStatut());
        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getGainPossible());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getLesEquipes());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Competition();
        $fixture->setNom('My Title');
        $fixture->setStatut('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setGainPossible('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setLesEquipes('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/competition/');
    }
}
