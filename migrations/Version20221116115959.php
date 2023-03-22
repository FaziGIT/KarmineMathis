<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116115959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, gain_possible INT NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, le_jeu_id INT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_2449BA152C94C912 (le_jeu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_competition (equipe_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_7F9ADD616D861B89 (equipe_id), INDEX IDX_7F9ADD617B39D312 (competition_id), PRIMARY KEY(equipe_id, competition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participer (id INT AUTO_INCREMENT NOT NULL, le_equipe_id INT DEFAULT NULL, la_competition_id INT DEFAULT NULL, gain_gagnã© INT DEFAULT NULL, INDEX IDX_EDBE16F8B49E0F7E (le_equipe_id), INDEX IDX_EDBE16F8C8A85F8E (la_competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, coach_id INT DEFAULT NULL, joueur_id INT DEFAULT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, sexe INT NOT NULL, role VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, nationalite VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, liquipedia VARCHAR(255) DEFAULT NULL, INDEX IDX_FCEC9EF3C105691 (coach_id), INDEX IDX_FCEC9EFA9E2D76C (joueur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA152C94C912 FOREIGN KEY (le_jeu_id) REFERENCES jeu (id)');
        $this->addSql('ALTER TABLE equipe_competition ADD CONSTRAINT FK_7F9ADD616D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_competition ADD CONSTRAINT FK_7F9ADD617B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8B49E0F7E FOREIGN KEY (le_equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8C8A85F8E FOREIGN KEY (la_competition_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF3C105691 FOREIGN KEY (coach_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EFA9E2D76C FOREIGN KEY (joueur_id) REFERENCES equipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA152C94C912');
        $this->addSql('ALTER TABLE equipe_competition DROP FOREIGN KEY FK_7F9ADD616D861B89');
        $this->addSql('ALTER TABLE equipe_competition DROP FOREIGN KEY FK_7F9ADD617B39D312');
        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F8B49E0F7E');
        $this->addSql('ALTER TABLE participer DROP FOREIGN KEY FK_EDBE16F8C8A85F8E');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF3C105691');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EFA9E2D76C');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_competition');
        $this->addSql('DROP TABLE jeu');
        $this->addSql('DROP TABLE participer');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
