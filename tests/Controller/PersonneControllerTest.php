<?php

namespace App\Test\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PersonneControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PersonneRepository $repository;
    private string $path = '/personne/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Personne::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Personne index');

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
            'personne[prenom]' => 'Testing',
            'personne[nom]' => 'Testing',
            'personne[pseudo]' => 'Testing',
            'personne[sexe]' => 'Testing',
            'personne[role]' => 'Testing',
            'personne[dateNaissance]' => 'Testing',
            'personne[nationalite]' => 'Testing',
            'personne[image]' => 'Testing',
            'personne[liquipedia]' => 'Testing',
            'personne[coach]' => 'Testing',
            'personne[joueur]' => 'Testing',
        ]);

        self::assertResponseRedirects('/personne/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Personne();
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');
        $fixture->setPseudo('My Title');
        $fixture->setSexe('My Title');
        $fixture->setRole('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setNationalite('My Title');
        $fixture->setImage('My Title');
        $fixture->setLiquipedia('My Title');
        $fixture->setCoach('My Title');
        $fixture->setJoueur('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Personne');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Personne();
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');
        $fixture->setPseudo('My Title');
        $fixture->setSexe('My Title');
        $fixture->setRole('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setNationalite('My Title');
        $fixture->setImage('My Title');
        $fixture->setLiquipedia('My Title');
        $fixture->setCoach('My Title');
        $fixture->setJoueur('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'personne[prenom]' => 'Something New',
            'personne[nom]' => 'Something New',
            'personne[pseudo]' => 'Something New',
            'personne[sexe]' => 'Something New',
            'personne[role]' => 'Something New',
            'personne[dateNaissance]' => 'Something New',
            'personne[nationalite]' => 'Something New',
            'personne[image]' => 'Something New',
            'personne[liquipedia]' => 'Something New',
            'personne[coach]' => 'Something New',
            'personne[joueur]' => 'Something New',
        ]);

        self::assertResponseRedirects('/personne/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPseudo());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getDateNaissance());
        self::assertSame('Something New', $fixture[0]->getNationalite());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getLiquipedia());
        self::assertSame('Something New', $fixture[0]->getCoach());
        self::assertSame('Something New', $fixture[0]->getJoueur());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Personne();
        $fixture->setPrenom('My Title');
        $fixture->setNom('My Title');
        $fixture->setPseudo('My Title');
        $fixture->setSexe('My Title');
        $fixture->setRole('My Title');
        $fixture->setDateNaissance('My Title');
        $fixture->setNationalite('My Title');
        $fixture->setImage('My Title');
        $fixture->setLiquipedia('My Title');
        $fixture->setCoach('My Title');
        $fixture->setJoueur('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/personne/');
    }
}
