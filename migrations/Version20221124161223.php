<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124161223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe_competition DROP FOREIGN KEY FK_7F9ADD617B39D312');
        $this->addSql('ALTER TABLE equipe_competition DROP FOREIGN KEY FK_7F9ADD616D861B89');
        $this->addSql('DROP TABLE equipe_competition');
        $this->addSql('ALTER TABLE participer CHANGE gain_gagn gain_gagnã© INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipe_competition (equipe_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_7F9ADD617B39D312 (competition_id), INDEX IDX_7F9ADD616D861B89 (equipe_id), PRIMARY KEY(equipe_id, competition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipe_competition ADD CONSTRAINT FK_7F9ADD617B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_competition ADD CONSTRAINT FK_7F9ADD616D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer CHANGE gain_gagnã© gain_gagn INT DEFAULT NULL');
    }
}
