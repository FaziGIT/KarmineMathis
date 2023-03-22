<?php

namespace App\DataFixtures;

use App\Entity\Competition;
use App\Entity\Equipe;
use App\Entity\Jeu;
use App\Entity\Personne;
use App\Entity\Sponsor;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        // Création des Fixtures pour l'entité competition
        $lesCompetition=$this->chargeFichier("competition.csv");

        $i=0;
        foreach ($lesCompetition as $value) { 
            $i++;
            $competition = new Competition();
            $competition -> setNom($value[1])
                         ->setStatut($value[2])
                         ->setDateDebut(new \DateTime($value[3]))
                         ->setGainPossible($value[4])
                         ->setDateFin(new \DateTime($value[5]));
            $manager->persist($competition);
            $this->addReference("competition" . $i,$competition);
        }

        // Création des Fixtures pour l'entité jeu
        $lesJeux=$this->chargeFichier("jeu.csv");
        $i=0;
        foreach ($lesJeux as $value) {
            $i++;
            $jeu = new Jeu();
            $jeu -> setNom($value[1])
                    ->setImage($value[2]);
            $manager->persist($jeu);
            $this->addReference("jeu" . $i,$jeu);
        }

        // Création des Fixtures pour l'entité equipe
        $lesEquipes=$this->chargeFichier("equipe.csv");
        $i=0;
        foreach ($lesEquipes as $value) {
            $i++;
            $equipe = new Equipe();
            $equipe -> setNom($value[1])
                    ->setImage($value[2])
                    ->setLeJeu($this->getReference("jeu" . mt_rand(1,5)));
            $manager->persist($equipe);
            $this->addReference("equipe" . $i,$equipe);
        }



        // Création des Fixtures pour l'entité personne
        $lesPersonnes=$this->chargeFichier("personne.csv");
        $i=0;
        foreach ($lesPersonnes as $value) {
            $i++;
            $personne = new Personne();
            $personne ->setPrenom($value[1])
                      ->setNom($value[2])
                      ->setPseudo($value[3])
                      ->setSexe(intval($value[4]))
                      ->setRole($value[5])
                      ->setDateNaissance(new \DateTime($value[6]))
                      ->setNationalite($value[7])
                      ->setImage($value[8])
                      ->setLiquipedia($value[9]);
            $manager->persist($personne);
            $this->addReference("personne" . $i,$personne);
        }


        // Création des Fixtures pour l'entité sponsor
        $lesSponsors=$this->chargeFichier("sponsor.csv");
        $i=0;
        foreach ($lesSponsors as $value) {
            $i++;
            $sponsor = new Sponsor();
            $sponsor -> setNom($value[1])
                    ->setImage($value[2])
                    ->setDescription($value[3]);
            $manager->persist($sponsor);
            $this->addReference("sponsor" . $i,$sponsor);
        }

        $manager->flush();
    }



    public function chargeFichier($fichier)
                {
                    $fichierCsv=fopen(__DIR__."/".$fichier,"r");
                    while (!feof($fichierCsv)) 
                    {
                        $data[] = fgetcsv($fichierCsv);
                    }
                    fclose($fichierCsv);
                    return $data;
                }
}
